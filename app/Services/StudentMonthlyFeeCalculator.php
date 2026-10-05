<?php

namespace App\Services;

use App\Models\ClassFee;
use App\Models\Fee;
use App\Models\FeeCollection;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class StudentMonthlyFeeCalculator
{
    protected array $monthNames = [
        1 => 'January',
        2 => 'February',
        3 => 'March',
        4 => 'April',
        5 => 'May',
        6 => 'June',
        7 => 'July',
        8 => 'August',
        9 => 'September',
        10 => 'October',
        11 => 'November',
        12 => 'December',
    ];

    public function monthToNumber(string|int $month): int
    {
        if (is_numeric($month)) {
            $value = (int) $month;

            return max(1, min(12, $value));
        }

        $normalized = ucfirst(strtolower(trim((string) $month)));
        $flipped = array_flip($this->monthNames);

        if (isset($flipped[$normalized])) {
            return $flipped[$normalized];
        }

        $parsed = strtotime('1 '.$month);

        return $parsed ? (int) date('n', $parsed) : (int) date('n');
    }

    public function monthLabel(int $month): string
    {
        return $this->monthNames[$month] ?? (string) $month;
    }

    /**
     * Sync class fees + compulsory Monthly Fees into fee_collections for one student/month.
     * Does not duplicate existing rows. Does not overwrite paid amounts.
     */
    public function syncStudentMonthFees(
        Student $student,
        int $month,
        int $year,
        ?string $paymentDate = null
    ): int {
        $student->loadMissing('studentClass');
        $created = 0;
        $paymentDate = $paymentDate ?: Carbon::create($year, $month, 1)->toDateString();

        $classFees = ClassFee::with('feeType')
            ->where('class_id', $student->class_id)
            ->where('status', 'Active')
            ->get();

        foreach ($classFees as $classFee) {
            if ($classFee->feeType && $classFee->feeType->is_adjustment) {
                continue;
            }

            if ($this->feeCollectionExists($student->id, $month, $year, (int) $classFee->fee_type_id, null, $classFee->fee_type)) {
                continue;
            }

            $catalogFee = Fee::query()
                ->where('class_id', $student->class_id)
                ->where('fee_type_id', $classFee->fee_type_id)
                ->where('is_adjustment', false)
                ->orderBy('id')
                ->first();

            FeeCollection::create([
                'student_id' => $student->id,
                'fee_type_id' => $classFee->fee_type_id,
                'fee_id' => $catalogFee?->id,
                'amount' => $classFee->amount,
                'amount_paid' => 0,
                'payment_date' => $paymentDate,
                'month' => $month,
                'year' => $year,
                'status' => 'Unpaid',
                'remarks' => $classFee->fee_type ?: optional($classFee->feeType)->fee_name,
            ]);

            $created++;
        }

        $before = FeeCollection::where('student_id', $student->id)
            ->where('month', $month)
            ->where('year', $year)
            ->count();

        $this->ensureMonthlyFee($student, $month, $year, $paymentDate);

        $after = FeeCollection::where('student_id', $student->id)
            ->where('month', $month)
            ->where('year', $year)
            ->count();

        return $created + max(0, $after - $before);
    }

    /**
     * Ensure Monthly Fees exists as an Unpaid charge for the month (no duplicates).
     */
    public function ensureMonthlyFee(
        Student $student,
        int $month,
        int $year,
        ?string $paymentDate = null
    ): void {
        $monthlyFee = $this->resolveMonthlyFeeCatalog($student);

        if (! $monthlyFee) {
            return;
        }

        if ($this->feeCollectionExists(
            $student->id,
            $month,
            $year,
            (int) $monthlyFee->fee_type_id,
            (int) $monthlyFee->id,
            $monthlyFee->description
        )) {
            return;
        }

        FeeCollection::create([
            'student_id' => $student->id,
            'fee_type_id' => $monthlyFee->fee_type_id,
            'fee_id' => $monthlyFee->id,
            'amount' => $monthlyFee->amount,
            'amount_paid' => 0,
            'payment_date' => $paymentDate ?: Carbon::create($year, $month, 1)->toDateString(),
            'month' => $month,
            'year' => $year,
            'status' => 'Unpaid',
            'remarks' => 'Monthly Fees',
        ]);
    }

    /**
     * Apply a month payment as an absolute amount against Total Due
     * (Previous Balance + Current Month Fees). Sets amount_paid on all
     * fee lines through the selected month so that:
     * Remaining = Total Due - Amount Paid
     * and unpaid balance carries forward to the next month.
     */
    public function applyMonthPayment(
        Student $student,
        int $month,
        int $year,
        float $paidAmount,
        ?string $paymentDate = null
    ): void {
        $groups = $this->buildMonthGroups($student);
        $target = $groups->first(fn ($group) => (int) $group['month'] === $month && (int) $group['year'] === $year);

        if (! $target) {
            throw new \InvalidArgumentException('No fee records found for the selected month.');
        }

        $totalDue = round((float) $target['total_due'], 2);
        $paidAmount = round($paidAmount, 2);

        if ($paidAmount < 0) {
            throw new \InvalidArgumentException('Paid amount cannot be negative.');
        }

        if ($paidAmount - $totalDue > 0.009) {
            throw new \InvalidArgumentException('Paid amount cannot be greater than total due.');
        }

        $paymentDate = $paymentDate ?: now()->toDateString();
        $targetUnpaid = max(0, round($totalDue - $paidAmount, 2));

        DB::transaction(function () use ($student, $month, $year, $targetUnpaid, $paymentDate) {
            $lines = FeeCollection::query()
                ->where('student_id', $student->id)
                ->get()
                ->filter(function ($line) use ($month, $year) {
                    $lineMonth = $this->monthToNumber($line->month);
                    $lineYear = (int) $line->year;

                    return $lineYear < $year
                        || ($lineYear === $year && $lineMonth <= $month);
                })
                ->sortBy(function ($line) {
                    return sprintf(
                        '%04d-%02d-%010d',
                        (int) $line->year,
                        $this->monthToNumber($line->month),
                        (int) $line->id
                    );
                })
                ->values();

            $sumAmounts = round((float) $lines->sum(fn ($line) => (float) $line->amount), 2);
            $remainingPayment = max(0, round($sumAmounts - $targetUnpaid, 2));

            foreach ($lines as $line) {
                $due = round((float) $line->amount, 2);
                $apply = min($due, max(0, $remainingPayment));
                $apply = round($apply, 2);

                $line->update([
                    'amount_paid' => $apply,
                    'payment_date' => $paymentDate,
                    'status' => $apply + 0.009 >= $due ? 'Paid' : 'Unpaid',
                ]);

                $remainingPayment = round($remainingPayment - $apply, 2);
            }
        });
    }

    /**
     * Build chronological month summaries with previous-balance carry-forward.
     *
     * @return Collection<int, array>
     */
    public function buildMonthGroups(Student $student): Collection
    {
        $student->loadMissing('studentClass');

        $records = FeeCollection::with(['fee', 'feeType'])
            ->where('student_id', $student->id)
            ->get()
            ->sortBy(function ($item) {
                return sprintf(
                    '%04d-%02d-%010d',
                    (int) $item->year,
                    $this->monthToNumber($item->month),
                    (int) $item->id
                );
            })
            ->values();

        $activityKeys = $records
            ->map(fn ($item) => $this->monthKey((int) $item->year, $this->monthToNumber($item->month)))
            ->unique()
            ->values();

        foreach ($activityKeys as $key) {
            [$year, $month] = array_map('intval', explode('-', $key));
            $this->ensureMonthlyFee($student, $month, $year);
        }

        $records = FeeCollection::with(['fee', 'feeType'])
            ->where('student_id', $student->id)
            ->get()
            ->sortBy(function ($item) {
                return sprintf(
                    '%04d-%02d-%010d',
                    (int) $item->year,
                    $this->monthToNumber($item->month),
                    (int) $item->id
                );
            })
            ->values();

        $grouped = $records->groupBy(function ($item) {
            return $this->monthKey((int) $item->year, $this->monthToNumber($item->month));
        })->sortKeys();

        $carry = 0.0;
        $summaries = collect();

        foreach ($grouped as $key => $items) {
            $first = $items->first();
            $month = $this->monthToNumber($first->month);
            $year = (int) $first->year;
            $monthLabel = $this->monthLabel($month);

            $fees = $items->values()->map(function ($item) use ($monthLabel) {
                $due = (float) $item->amount;
                $paid = $this->paidAmount($item);

                return [
                    'id' => $item->id,
                    'fee_name' => $this->resolveFeeName($item),
                    'amount' => $due,
                    'amount_paid' => $paid,
                    'remaining' => max(0, $due - $paid),
                    'status' => $item->status,
                    'month' => $monthLabel,
                    'year' => $item->year,
                    'receive_date' => $item->payment_date
                        ? Carbon::parse($item->payment_date)->format('d-m-Y')
                        : '-',
                    'is_monthly' => $this->isMonthlyFeeName($this->resolveFeeName($item)),
                ];
            })->all();

            $currentFeesTotal = round(collect($fees)->sum('amount'), 2);
            $paidThisMonth = round(collect($fees)->sum('amount_paid'), 2);
            $previousBalance = round($carry, 2);
            $totalDue = round($previousBalance + $currentFeesTotal, 2);
            // Paid toward this month's bill = prior unpaid cleared is already in reduced previous;
            // display paid as amount applied to this month's lines, remaining uses bill formula:
            $remaining = max(0, round($totalDue - $paidThisMonth, 2));

            // When previous balance exists and current lines are fully paid, remaining still includes previous.
            // Correct remaining must subtract only payments that apply to the full bill.
            // Recompute remaining as unpaid on this and prior months after cascade of line balances:
            $lineUnpaidThroughMonth = $records
                ->filter(function ($item) use ($month, $year) {
                    $itemMonth = $this->monthToNumber($item->month);
                    $itemYear = (int) $item->year;

                    return $itemYear < $year
                        || ($itemYear === $year && $itemMonth <= $month);
                })
                ->sum(function ($item) {
                    return max(0, (float) $item->amount - $this->paidAmount($item));
                });

            $remaining = max(0, round((float) $lineUnpaidThroughMonth, 2));
            // Paid toward total due for display = totalDue - remaining
            $paidTowardDue = max(0, round($totalDue - $remaining, 2));

            $dates = $items
                ->map(function ($item) {
                    return $item->payment_date
                        ? Carbon::parse($item->payment_date)->format('d-m-Y')
                        : null;
                })
                ->filter()
                ->unique()
                ->values();

            $summary = [
                'key' => $key,
                'month' => $month,
                'year' => $year,
                'month_label' => $monthLabel,
                'title' => $monthLabel . ' ' . $year,
                'record_count' => $items->count(),
                'representative_id' => $items->sortByDesc('id')->first()->id,
                'receive_date' => $dates->count() === 1 ? $dates->first() : ($dates->first() ?? '-'),
                'mixed_dates' => $dates->count() > 1,
                'fees' => $fees,
                'ids' => $items->pluck('id')->values()->all(),
                'previous_balance' => $previousBalance,
                'current_fees_total' => $currentFeesTotal,
                'total_due' => $totalDue,
                'paid' => $paidTowardDue,
                'paid_on_month_lines' => $paidThisMonth,
                'remaining' => $remaining,
                'total' => $totalDue,
                'student_name' => $student->name,
            ];

            $summaries->push($summary);
            $carry = $remaining;
        }

        return $summaries->sortByDesc(fn ($row) => $row['key'])->values();
    }

    public function resolveMonthlyFeeCatalog(Student $student): ?Fee
    {
        if (! $student->class_id) {
            return null;
        }

        return Fee::query()
            ->where('class_id', $student->class_id)
            ->where('is_adjustment', false)
            ->where(function ($query) {
                $query->where('description', 'like', 'Monthly Fee%')
                    ->orWhere('description', 'like', 'Monthly Fees%');
            })
            ->orderBy('id')
            ->first();
    }

    protected function feeCollectionExists(
        int $studentId,
        int $month,
        int $year,
        int $feeTypeId,
        ?int $feeId = null,
        ?string $nameHint = null
    ): bool {
        $rows = FeeCollection::with(['fee', 'feeType'])
            ->where('student_id', $studentId)
            ->where('year', $year)
            ->get()
            ->filter(fn ($row) => $this->monthToNumber($row->month) === $month);

        $hint = strtolower(trim((string) $nameHint));

        return $rows->contains(function ($row) use ($feeId, $hint) {
            if ($feeId && (int) $row->fee_id === (int) $feeId) {
                return true;
            }

            $name = strtolower(trim((string) (
                $row->fee->description
                ?? $row->feeType->fee_name
                ?? $row->remarks
                ?? ''
            )));

            $remarks = strtolower(trim((string) ($row->remarks ?? '')));

            if ($hint === '') {
                return false;
            }

            if ($name === $hint || $remarks === $hint) {
                return true;
            }

            return str_contains($hint, 'monthly fee')
                && str_contains($name, 'monthly fee');
        });
    }

    protected function paidAmount(FeeCollection $item): float
    {
        if ($item->amount_paid !== null) {
            return (float) $item->amount_paid;
        }

        return strtolower((string) $item->status) === 'paid'
            ? (float) $item->amount
            : 0.0;
    }

    protected function resolveFeeName(FeeCollection $item): string
    {
        return $item->fee->description
            ?? (
                $item->feeType
                && ! in_array($item->feeType->fee_name, ['Fee', 'Discount'], true)
                    ? $item->feeType->fee_name
                    : null
            )
            ?? ($item->remarks ?: '-');
    }

    protected function isMonthlyFeeName(string $name): bool
    {
        return str_contains(strtolower($name), 'monthly fee');
    }

    protected function monthKey(int $year, int $month): string
    {
        return $year . '-' . str_pad((string) $month, 2, '0', STR_PAD_LEFT);
    }
}
