<?php

namespace App\Http\Controllers;

use App\Models\ClassFee;
use App\Models\FeeType;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\FeeCollection;
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
    'fee_type'    => 'required',
    'amount'      => 'required|numeric|min:0',
    'status'      => 'required',
]);

   ClassFee::updateOrCreate(
    [
        'class_id' => $class,
        'fee_type_id' => $request->fee_type_id,
    ],
    [
        'fee_type' => $request->fee_type,
        'amount'   => $request->amount,
        'status'   => $request->status,
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

    foreach ($students as $student) {

        foreach ($classFees as $fee) {

            FeeCollection::updateOrCreate(
                [
                    'student_id' => $student->id,
                    'fee_type_id' => $fee->fee_type_id,
                    'month' => Carbon::now()->format('F'),
                    'year' => Carbon::now()->year,
                ],
                [
                    'amount' => $fee->amount,
                    'payment_date' => Carbon::now(),
                    'status' => 'Unpaid',
                    'remarks' => null,
                ]
            );

        }

    }
}
}