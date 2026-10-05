<?php

namespace App\Http\Controllers;

use App\Models\FeeCollection;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
use App\Models\Admission;
use App\Services\StudentMonthlyFeeCalculator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class FeeCollectionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | RECEIVED FEES LIST
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $classes = StudentClass::orderBy('class_name')->get();

        $sections = Section::orderBy('section_name')->get();

        $query = FeeCollection::with([
            'student.studentClass',
            'student.section',
            'feeType',
        ]);

        if ($request->filled('student')) {

            $search = $request->student;

            $query->whereHas('student', function ($q) use ($search) {

                $q->where(
                    'name',
                    'like',
                    '%' . $search . '%'
                );
            });
        }

        if ($request->filled('family_no')) {

            $familyNo = $request->family_no;

            $query->whereHas('student', function ($q) use ($familyNo) {

                /*
                |--------------------------------------------------------------------------
                | family_no is not in students table.
                | Family search is handled through admissions table.
                |--------------------------------------------------------------------------
                */

                $studentNames = Admission::where(
                    'family_no',
                    'like',
                    '%' . $familyNo . '%'
                )
                ->pluck('student_name');

                $q->whereIn('name', $studentNames);
            });
        }

        if ($request->filled('class_id')) {

            $query->whereHas('student', function ($q) use ($request) {

                $q->where(
                    'class_id',
                    $request->class_id
                );
            });
        }

        if ($request->filled('section_id')) {

            $query->whereHas('student', function ($q) use ($request) {

                $q->where(
                    'section_id',
                    $request->section_id
                );
            });
        }

        $collections = $query
            ->orderByDesc('id')
            ->get();

        $collections = $collections
            ->unique('student_id')
            ->values();

        return view(
            'fee-collections.index',
            compact(
                'collections',
                'classes',
                'sections'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $students = Student::with([
            'studentClass.fees.feeType'
        ])->get();

        $feeTypes = \App\Models\FeeType::all();

        return view(
            'fee-collections.create',
            compact(
                'students',
                'feeTypes'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([

            'student_id' =>
                'required|exists:students,id',

            'fee_type_id' =>
                'required|array',

            'fee_type_id.*' =>
                'required|exists:fee_types,id',

            'amount' =>
                'required|array',

            'amount.*' =>
                'required|numeric|min:0',

            'month' =>
                'required',

            'year' =>
                'required',

            'payment_date' =>
                'required|date',

            'status' =>
                'required',

            'remarks' =>
                'nullable|string',

        ]);

        foreach ($request->fee_type_id as $feeTypeId) {

            $alreadyExists = FeeCollection::where(
                'student_id',
                $request->student_id
            )
                ->where(
                    'fee_type_id',
                    $feeTypeId
                )
                ->where(
                    'month',
                    $request->month
                )
                ->where(
                    'year',
                    $request->year
                )
                ->exists();

            if ($alreadyExists) {

                return back()
                    ->withInput()
                    ->withErrors([

                        'fee_type_id' =>
                            'This fee has already been added for this student for the selected month and year.'

                    ]);
            }
        }

        foreach (
            $request->fee_type_id
            as $index => $feeTypeId
        ) {

            FeeCollection::create([

                'student_id' =>
                    $request->student_id,

                'fee_type_id' =>
                    $feeTypeId,

                'amount' =>
                    $request->amount[$index],

                'amount_paid' =>
                    strtolower((string) $request->status) === 'paid'
                        ? $request->amount[$index]
                        : 0,

                'payment_date' =>
                    $request->payment_date,

                'month' =>
                    $request->month,

                'year' =>
                    $request->year,

                'status' =>
                    $request->status,

                'remarks' =>
                    $request->remarks,

            ]);
        }

        return redirect()
            ->route('fee-collections.index')
            ->with(
                'success',
                'All Fees Collected Successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show(FeeCollection $fee_collection)
    {
        $fee_collection->load([
            'student.studentClass',
            'student.section',
            'feeType',
            'fee',
        ]);

        $calculator = app(StudentMonthlyFeeCalculator::class);
        $monthGroups = $calculator->buildMonthGroups($fee_collection->student);

        $receivedFeesByMonth = [];
        foreach ($monthGroups as $group) {
            $receivedFeesByMonth[$group['key']] = $group;
        }

        $records = FeeCollection::with(['fee', 'feeType'])
            ->where('student_id', $fee_collection->student_id)
            ->orderByDesc('year')
            ->orderByDesc('month')
            ->orderByDesc('id')
            ->get();

        $monthNames = [
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

        return view(
            'fee-collections.show',
            compact(
                'fee_collection',
                'records',
                'monthGroups',
                'receivedFeesByMonth',
                'monthNames'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RECEIVE FEE PAGE
    |--------------------------------------------------------------------------
    */

    public function receive(FeeCollection $fee_collection)
    {
        $fee_collection->load([
            'student.studentClass',
            'student.section',
            'feeType',
        ]);

        $student = $fee_collection->student;

        $allFees = FeeCollection::where(
            'student_id',
            $student->id
        )->get();

        $totalReceived = $allFees
            ->filter(function ($fee) {

                return strtolower(
                    $fee->status ?? ''
                ) === 'paid';

            })
            ->sum('amount');

        $totalArrears = $allFees
            ->filter(function ($fee) {

                return strtolower(
                    $fee->status ?? ''
                ) !== 'paid';

            })
            ->sum('amount');

        $currentMonth = Carbon::now()->month;

        $currentYear = Carbon::now()->year;

        $currentMonthFee = $allFees
            ->filter(function ($fee) use (
                $currentMonth,
                $currentYear
            ) {

                return (int) $fee->month === $currentMonth
                    && (int) $fee->year === $currentYear;

            })
            ->sum('amount');

        $feeAmount = $fee_collection->amount ?? 0;

        $defaulter = $totalArrears;

        $reliefAmount = 0;

        $remainingBalance = max(
            0,
            $currentMonthFee -
            $feeAmount -
            $reliefAmount
        );

        $receiveDate = $fee_collection->payment_date
            ? Carbon::parse(
                $fee_collection->payment_date
            )->format('Y-m-d')
            : '';

        return view(
            'fee-collections.receive',
            compact(
                'fee_collection',
                'student',
                'feeAmount',
                'defaulter',
                'currentMonthFee',
                'totalReceived',
                'totalArrears',
                'remainingBalance',
                'reliefAmount',
                'receiveDate'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | RECEIVE FEE / UPDATE
    |--------------------------------------------------------------------------
    */

    public function receiveUpdate(
        Request $request,
        FeeCollection $fee_collection
    ) {

        $request->validate([

            'payment_date' =>
                'required|date',

            'amount' =>
                'required|numeric|min:0',

            'relief_amount' =>
                'nullable|numeric|min:0',

        ]);

        $due = (float) $fee_collection->amount;
        $paid = min($due, (float) $request->amount);

        $fee_collection->update([
            'amount_paid' => $paid,
            'payment_date' => $request->payment_date,
            'status' => $paid >= $due ? 'Paid' : 'Unpaid',
        ]);

        return redirect()
            ->route(
                'fee-collections.index'
            )
            ->with(
                'success',
                'Fee Received Successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT FEE
    |--------------------------------------------------------------------------
    */

    public function edit(FeeCollection $fee_collection)
    {
        $fee_collection->load([
            'student.studentClass',
            'student.section',
            'feeType',
        ]);

        return view(
            'fee-collections.edit',
            compact('fee_collection')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE FEE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        FeeCollection $fee_collection
    ) {

        $request->validate([

            'amount' =>
                'required|numeric|min:0',

            'payment_date' =>
                'nullable|date',

            'relief_amount' =>
                'nullable|numeric|min:0',

        ]);

        $fee_collection->update([

            'amount' =>
                $request->amount,

            'payment_date' =>
                $request->payment_date
                    ?? $fee_collection->payment_date,

        ]);

        return redirect()
            ->route('fee-collections.index')
            ->with(
                'success',
                'Fee Updated Successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy(FeeCollection $fee_collection)
    {
        $fee_collection->delete();

        return redirect()
            ->route('fee-collections.index')
            ->with(
                'success',
                'Receive Fees List Deleted Successfully.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT MONTH GROUP
    |--------------------------------------------------------------------------
    */

    public function editMonth(Request $request, FeeCollection $fee_collection)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required|integer',
        ]);

        $month = (int) $request->month;
        $year = (int) $request->year;

        $fee_collection->load([
            'student.studentClass',
            'student.section',
        ]);

        $monthRecords = FeeCollection::with(['fee', 'feeType'])
            ->where('student_id', $fee_collection->student_id)
            ->where('month', $month)
            ->where('year', $year)
            ->orderBy('id')
            ->get();

        if ($monthRecords->isEmpty()) {
            return redirect()
                ->route('fee-collections.show', $fee_collection->id)
                ->with('error', 'No fee records found for the selected month.');
        }

        $monthNames = [
            1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April',
            5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August',
            9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December',
        ];

        return view('fee-collections.month-edit', [
            'fee_collection' => $fee_collection,
            'monthRecords' => $monthRecords,
            'month' => $month,
            'year' => $year,
            'monthLabel' => $monthNames[$month] ?? (string) $month,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE MONTH GROUP
    |--------------------------------------------------------------------------
    */

    public function updateMonth(Request $request, FeeCollection $fee_collection)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required|integer',
            'amounts' => 'required|array|min:1',
            'amounts.*' => 'required|numeric|min:0',
        ]);

        $month = (int) $request->month;
        $year = (int) $request->year;
        $amounts = $request->amounts;

        $monthRecords = FeeCollection::where('student_id', $fee_collection->student_id)
            ->where('month', $month)
            ->where('year', $year)
            ->whereIn('id', array_keys($amounts))
            ->get();

        foreach ($monthRecords as $record) {
            if (! array_key_exists($record->id, $amounts)
                && ! array_key_exists((string) $record->id, $amounts)) {
                continue;
            }

            $newAmount = (float) ($amounts[$record->id] ?? $amounts[(string) $record->id]);
            $paid = min($newAmount, (float) ($record->amount_paid ?? 0));

            $record->update([
                'amount' => $newAmount,
                'amount_paid' => $paid,
                'status' => $paid >= $newAmount && $newAmount > 0 ? 'Paid' : (
                    $paid > 0 ? 'Unpaid' : 'Unpaid'
                ),
            ]);
        }

        $remaining = FeeCollection::where('student_id', $fee_collection->student_id)
            ->orderByDesc('id')
            ->first();

        return redirect()
            ->route(
                'fee-collections.show',
                $remaining ? $remaining->id : $fee_collection->id
            )
            ->with('success', 'Month fee records updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | RECEIVE MONTH GROUP PAYMENT
    |--------------------------------------------------------------------------
    */

    public function receiveMonth(Request $request, FeeCollection $fee_collection)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required|integer',
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
        ]);

        $calculator = app(StudentMonthlyFeeCalculator::class);
        $month = $calculator->monthToNumber($request->month);
        $year = (int) $request->year;
        $student = $fee_collection->student()->first() ?? $fee_collection->student;

        if (! $student) {
            return back()->withErrors([
                'amount_paid' => 'Student not found for this fee record.',
            ]);
        }

        try {
            $calculator->applyMonthPayment(
                $student,
                $month,
                $year,
                (float) $request->amount_paid,
                $request->payment_date
            );
        } catch (\InvalidArgumentException $e) {
            return back()->withErrors([
                'amount_paid' => $e->getMessage(),
            ]);
        }

        $remaining = FeeCollection::where('student_id', $student->id)
            ->orderByDesc('id')
            ->first();

        return redirect()
            ->route('fee-collections.show', $remaining ? $remaining->id : $fee_collection->id)
            ->with('success', 'Payment saved successfully. Remaining balance will carry forward to the next month if unpaid.');
    }

    public function destroyMonth(Request $request, FeeCollection $fee_collection)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required|integer',
        ]);

        $month = (int) $request->month;
        $year = (int) $request->year;
        $studentId = $fee_collection->student_id;

        FeeCollection::where('student_id', $studentId)
            ->where('month', $month)
            ->where('year', $year)
            ->delete();

        $remaining = FeeCollection::where('student_id', $studentId)
            ->orderByDesc('id')
            ->first();

        if ($remaining) {
            return redirect()
                ->route('fee-collections.show', $remaining->id)
                ->with('success', 'All received fee records for the selected month were deleted.');
        }

        return redirect()
            ->route('fee-collections.index')
            ->with('success', 'All received fee records for the selected month were deleted.');
    }


    /*
    |--------------------------------------------------------------------------
    | STUDENT FEE HISTORY
    |--------------------------------------------------------------------------
    */

    public function history(FeeCollection $fee_collection)
    {
        $studentId =
            $fee_collection->student_id;

        $student = Student::with([
            'studentClass',
            'section',
        ])->find($studentId);

        $fees = FeeCollection::where(
            'student_id',
            $studentId
        )
            ->orderBy('year')
            ->orderBy('month')
            ->orderBy('id')
            ->get();

        $history = $fees
            ->groupBy(function ($fee) {

                return $fee->year .
                    '-' .
                    $fee->month;

            })
            ->map(function ($monthlyFees) {

                $monthId = $monthlyFees
                    ->sortByDesc('id')
                    ->first()
                    ->id;

                $totalCharged =
                    $monthlyFees->sum('amount');

                $received = $monthlyFees
                    ->filter(function ($fee) {

                        return strtolower(
                            $fee->status ?? ''
                        ) === 'paid';

                    })
                    ->sum('amount');

                $processed =
                    $received;

                $monthlyDifference =
                    $totalCharged -
                    $received;

                return [

                    'month_id' =>
                        $monthId,

                    'month' =>
                        $monthlyFees
                            ->first()
                            ->month
                        . '-' .
                        $monthlyFees
                            ->first()
                            ->year,

                    'total_charged' =>
                        $totalCharged,

                    'discount' =>
                        0,

                    'processed' =>
                        $processed,

                    'received' =>
                        $received,

                    'monthly_difference' =>
                        $monthlyDifference,

                ];
            })
            ->values();

        $cumulative = 0;

        $history = $history
            ->map(function ($item) use (&$cumulative) {

                $cumulative +=
                    $item['monthly_difference'];

                $item['defaulter'] =
                    $cumulative;

                return $item;

            });

        return response()->json([

            'student' => [

                'name' =>
                    $student->name ?? '-',

                'class' =>
                    optional(
                        $student->studentClass
                    )->class_name ?? '-',

                'section' =>
                    optional(
                        $student->section
                    )->section_name ?? '-',

            ],

            'history' =>
                $history,

        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | CHALLAN
    |--------------------------------------------------------------------------
    */

    public function challan(
        FeeCollection $fee_collection
    ) {

        $fee_collection->load([

            'student.studentClass',
            'student.section',
            'feeType',

        ]);

        $fees = FeeCollection::with(
            'feeType'
        )
            ->where(
                'student_id',
                $fee_collection->student_id
            )
            ->where(
                'month',
                $fee_collection->month
            )
            ->where(
                'year',
                $fee_collection->year
            )
            ->get();

        $totalAmount =
            $fees->sum('amount');

        $pdf = Pdf::loadView(
            'fee-collections.challan',
            compact(
                'fee_collection',
                'fees',
                'totalAmount'
            )
        );

        return $pdf->download(
            'fee-challan-' .
            $fee_collection->id .
            '.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FEE WARNING
    |--------------------------------------------------------------------------
    */

    public function feeWarning(
        FeeCollection $fee_collection
    ) {

        $fee_collection->load([
            'student.studentClass',
            'student.section',
            'feeType',
        ]);

        $student =
            $fee_collection->student;

        $fees = FeeCollection::with('feeType')
            ->where(
                'student_id',
                $student->id
            )
            ->where(function ($query) {

                $query->where(
                    'status',
                    '!=',
                    'Paid'
                )
                ->orWhereNull('status');

            })
            ->orderBy('year')
            ->orderBy('month')
            ->orderBy('id')
            ->get();

        $totalAmount =
            $fees->sum('amount');

        $pdf = Pdf::loadView(
            'fee-collections.warning',
            compact(
                'fee_collection',
                'student',
                'fees',
                'totalAmount'
            )
        );

        $pdf->setPaper(
            'A4',
            'portrait'
        );

        return $pdf->stream(
            'fee-warning-' .
            $student->id .
            '.pdf'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | FAMILY DEFAULTER REPORT
    |--------------------------------------------------------------------------
    */

    public function familyDefaulters()
    {
        /*
        |--------------------------------------------------------------------------
        | Get all students
        |--------------------------------------------------------------------------
        */

        $students = Student::with([
            'studentClass',
            'section',
        ])
        ->orderBy('name')
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Get admission records
        |
        | family_no and father_contact are stored in admissions table.
        |--------------------------------------------------------------------------
        */

        $admissions = Admission::orderBy('id', 'desc')
            ->get()
            ->groupBy(function ($admission) {

                return strtolower(
                    trim($admission->student_name ?? '')
                );

            });


        /*
        |--------------------------------------------------------------------------
        | Prepare Family Data
        |--------------------------------------------------------------------------
        */

        $families = collect();


        foreach ($students as $student) {

            $studentName =
                strtolower(
                    trim($student->name ?? '')
                );


            /*
            |--------------------------------------------------------------------------
            | Find Admission
            |--------------------------------------------------------------------------
            */

            $admissionGroup =
                $admissions->get(
                    $studentName,
                    collect()
                );


            $admission =
                $admissionGroup->first();


            /*
            |--------------------------------------------------------------------------
            | Family Number
            |--------------------------------------------------------------------------
            */

            $familyNo =
                $admission->family_no
                ?? '';


            /*
            |--------------------------------------------------------------------------
            | Create unique family key
            |--------------------------------------------------------------------------
            */

            if ($familyNo !== '') {

                $familyKey =
                    'family_' . $familyNo;

            } else {

                /*
                |--------------------------------------------------------------------------
                | Students without family number stay separate
                |--------------------------------------------------------------------------
                */

                $familyKey =
                    'student_' . $student->id;
            }


            /*
            |--------------------------------------------------------------------------
            | Student Info
            |--------------------------------------------------------------------------
            */

            $studentCode =
                $student->student_code
                ?? $student->id;


            /*
            |--------------------------------------------------------------------------
            | Father Contact
            |--------------------------------------------------------------------------
            */

            $fatherContact =
                $admission->father_contact
                ?? '';


            /*
            |--------------------------------------------------------------------------
            | Calculate Defaulter Balance
            |--------------------------------------------------------------------------
            */

            $studentDefaulter =
                FeeCollection::where(
                    'student_id',
                    $student->id
                )
                ->where(function ($query) {

                    $query->where(
                        'status',
                        '!=',
                        'Paid'
                    )
                    ->orWhereNull('status');

                })
                ->sum('amount');


            /*
            |--------------------------------------------------------------------------
            | Add / Update Family
            |--------------------------------------------------------------------------
            */

            if (!$families->has($familyKey)) {

                $families->put(
                    $familyKey,
                    [

                        'family_no' =>
                            $familyNo,

                        'total_students' =>
                            0,

                        'student_info' =>
                            [],

                        'father_contacts' =>
                            [],

                        'defaulter_balance' =>
                            0,

                    ]
                );
            }


            $family =
                $families->get($familyKey);


            /*
            |--------------------------------------------------------------------------
            | Total Students
            |--------------------------------------------------------------------------
            */

            $family['total_students'] =
                $family['total_students'] + 1;


            /*
            |--------------------------------------------------------------------------
            | Student Information
            |--------------------------------------------------------------------------
            */

            $family['student_info'][] = [

                'name' =>
                    $student->name ?? '-',

                'student_code' =>
                    $studentCode,

            ];


            /*
            |--------------------------------------------------------------------------
            | Father Contact
            |--------------------------------------------------------------------------
            */

            if ($fatherContact !== '') {

                $family['father_contacts'][] =
                    $fatherContact;
            }


            /*
            |--------------------------------------------------------------------------
            | Family Defaulter
            |--------------------------------------------------------------------------
            */

            $family['defaulter_balance'] =
                $family['defaulter_balance']
                + $studentDefaulter;


            $families->put(
                $familyKey,
                $family
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Clean Family Data
        |--------------------------------------------------------------------------
        */

        $families =
            $families
                ->map(function ($family) {

                    $family['father_contacts'] =
                        collect(
                            $family['father_contacts']
                        )
                        ->filter()
                        ->unique()
                        ->values()
                        ->toArray();


                    return $family;

                })
                ->values();


        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView(
            'fee-collections.family-defaulters',
            compact('families')
        );


        /*
        |--------------------------------------------------------------------------
        | PDF Paper
        |--------------------------------------------------------------------------
        */

        $pdf->setPaper(
            'A4',
            'landscape'
        );


        /*
        |--------------------------------------------------------------------------
        | Open PDF
        |--------------------------------------------------------------------------
        */

        return $pdf->stream(
            'family-defaulter-report.pdf'
        );
    }
}