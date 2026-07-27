<?php

namespace App\Http\Controllers;

use App\Models\FeeCollection;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeCollectionController extends Controller
{
    public function index()
    {
        $collections = FeeCollection::with([
            'student.studentClass'
        ])->get();

        return view('fee-collections.index', compact('collections'));
    }

    public function create()
    {
        $students = Student::with([
            'studentClass.fees.feeType'
        ])->get();

        return view('fee-collections.create', compact('students'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'fee_type_id'  => 'required|exists:fee_types,id',
            'amount'       => 'required|numeric',
            'payment_date' => 'required|date',
            'status'       => 'required',
            'remarks'      => 'nullable|string',
        ]);

        FeeCollection::create([
            'student_id'   => $request->student_id,
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date,
            'status'       => $request->status,
            'remarks'      => $request->remarks,
        ]);

        return redirect()
            ->route('fee-collections.index')
            ->with('success', 'Fee Collected Successfully.');
    }

    public function show(FeeCollection $fee_collection)
    {
        $fee_collection->load([
            'student.studentClass'
        ]);

        return view('fee-collections.show', compact('fee_collection'));
    }

    public function edit(FeeCollection $fee_collection)
    {
        $students = Student::with([
            'studentClass.fees.feeType'
        ])->get();

        return view('fee-collections.edit', compact(
            'fee_collection',
            'students'
        ));
    }

    public function update(Request $request, FeeCollection $fee_collection)
    {
        $request->validate([
            'student_id'   => 'required|exists:students,id',
            'fee_type_id'  => 'required|exists:fee_types,id',
            'amount'       => 'required|numeric',
            'payment_date' => 'required|date',
            'status'       => 'required',
            'remarks'      => 'nullable|string',
        ]);

        $fee_collection->update([
            'student_id'   => $request->student_id,
            'amount'       => $request->amount,
            'payment_date' => $request->payment_date,
            'status'       => $request->status,
            'remarks'      => $request->remarks,
        ]);

        return redirect()
            ->route('fee-collections.index')
            ->with('success', 'Fee Collection Updated Successfully.');
    }

    public function destroy(FeeCollection $fee_collection)
    {
        $fee_collection->delete();

        return redirect()
            ->route('fee-collections.index')
            ->with('success', 'Fee Collection Deleted Successfully.');
    }
}