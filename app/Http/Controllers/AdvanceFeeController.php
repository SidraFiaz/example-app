<?php

namespace App\Http\Controllers;

use App\Models\AdvanceFee;
use App\Models\Student;
use Illuminate\Http\Request;

class AdvanceFeeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $advanceFees = AdvanceFee::with([
            'student.studentClass'
        ])
        ->latest()
        ->get();

        return view(
            'advance-fees.index',
            compact('advanceFees')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $students = Student::with('studentClass')
            ->orderBy('name')
            ->get();

        return view(
            'advance-fees.create',
            compact('students')
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
            'student_id' => 'required|exists:students,id',
            'advance_month' => 'required|date',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        AdvanceFee::create([
            'student_id' => $request->student_id,
            'advance_month' => $request->advance_month,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
            'adjusted_amount' => 0,
        ]);

        return redirect()
            ->route('advance-fees.index')
            ->with('success', 'Advance Fee saved successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $advanceFee = AdvanceFee::with([
            'student.studentClass'
        ])->findOrFail($id);

        return view(
            'advance-fees.show',
            compact('advanceFee')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $advanceFee = AdvanceFee::findOrFail($id);

        $students = Student::with('studentClass')
            ->orderBy('name')
            ->get();

        return view(
            'advance-fees.edit',
            compact(
                'advanceFee',
                'students'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $advanceFee = AdvanceFee::findOrFail($id);

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'advance_month' => 'required|date',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        $advanceFee->update([
            'student_id' => $request->student_id,
            'advance_month' => $request->advance_month,
            'payment_date' => $request->payment_date,
            'amount' => $request->amount,
        ]);

        return redirect()
            ->route('advance-fees.index')
            ->with('success', 'Advance Fee updated successfully.');
    }


    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $advanceFee = AdvanceFee::findOrFail($id);

        $advanceFee->delete();

        return redirect()
            ->route('advance-fees.index')
            ->with('success', 'Advance Fee deleted successfully.');
    }
}