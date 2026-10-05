<?php

namespace App\Http\Controllers;

use App\Models\ClassFee;
use App\Models\FeeType;
use App\Models\StudentClass;
use App\Models\Discount;
use App\Models\Student;
use App\Models\FeeCollection;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ClassFeeController extends Controller
{
    public function index($class)
    {
        $studentClass = StudentClass::findOrFail($class);

        $classFees = ClassFee::with('feeType')
            ->where('class_id', $class)
            ->get();

        return view('class-fees.index', compact('studentClass', 'classFees'));
    }

    public function create($class)
    {
        $studentClass = StudentClass::findOrFail($class);

        $feeTypes = FeeType::all();

        return view('class-fees.create', compact('studentClass', 'feeTypes'));
    }

    public function store(Request $request, $class)
    {
        $request->validate([
            'fee_type_id' => 'required',
            'amount' => 'required|numeric|min:0',
            'status' => 'required',
        ]);

        $feeType = FeeType::findOrFail($request->fee_type_id);

        ClassFee::updateOrCreate(
            [
                'class_id' => $class,
                'fee_type_id' => $request->fee_type_id,
            ],
            [
                'fee_type' => $feeType->fee_name,
                'amount' => $request->amount,
                'status' => $request->status,
            ]
        );

        return redirect()
            ->route('class-fees.index', $class)
            ->with('success', 'Class Fee Saved Successfully.');
    }

    public function process($class)
    {
        $students = Student::where('class_id', $class)->get();

        $classFees = ClassFee::where('class_id', $class)
            ->where('status', 'Active')
            ->get();

        $month = Carbon::now()->format('F');
        $year = Carbon::now()->year;
        $today = Carbon::now();

        foreach ($students as $student) {

            foreach ($classFees as $fee) {

                $originalAmount = (float) $fee->amount;

                // Student-wise discount
                $discount = Discount::where('student_id', $student->id)
                    ->where('status', 'Active')
                    ->first();

                // Class-wise discount
                if (!$discount) {
                    $discount = Discount::where('class_id', $class)
                        ->whereNull('student_id')
                        ->where('status', 'Active')
                        ->first();
                }

                $finalAmount = $originalAmount;

                if ($discount) {

                    $type = strtolower($discount->discount_type);
                    $value = (float) $discount->discount_value;

                    if ($type === 'percentage' || $type === 'percent') {

                        $discountAmount = ($originalAmount * $value) / 100;

                        $finalAmount = $originalAmount - $discountAmount;

                    } elseif ($type === 'fixed' || $type === 'amount') {

                        $finalAmount = $originalAmount - $value;
                    }

                    if ($finalAmount < 0) {
                        $finalAmount = 0;
                    }
                }

                FeeCollection::updateOrCreate(
                    [
                        'student_id' => $student->id,
                        'fee_type_id' => $fee->fee_type_id,
                        'month' => $month,
                        'year' => $year,
                    ],
                    [
                        'amount' => $finalAmount,
                        'payment_date' => $today,
                        'status' => 'Unpaid',
                        'remarks' => null,
                    ]
                );
            }
        }

        return redirect()
            ->route('class-fees.index', $class)
            ->with('success', 'Fees Processed Successfully with discount.');
    }
}