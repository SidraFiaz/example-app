<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\StudentClass;
use App\Models\FeeType;
use Illuminate\Http\Request;


class FeeController extends Controller
{
public function index(Request $request)
{
    $search = $request->search;

    $classes = StudentClass::when($search, function ($query) use ($search) {
        $query->where('class_name', 'like', "%{$search}%");
    })->get();

    return view('fees.index', compact('classes', 'search'));
}
  public function create(Request $request)
{
    $classes = StudentClass::all();
    $feeTypes = FeeType::all();

    $selectedClass = $request->class_id;

    return view('fees.create', compact(
        'classes',
        'feeTypes',
        'selectedClass'
    ));
}
public function store(Request $request)
{
    $request->validate([
        'class_id'    => 'required',
        'fee_type_id' => 'required',
        'amount'      => 'required|numeric',
    ]);

    // Sirf Monthly Fee ek hi baar allow hogi
    if ($request->fee_type_id == 2) {

        $exists = Fee::where('class_id', $request->class_id)
            ->where('fee_type_id', 2)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors([
                    'class_id' => 'This class already has a Monthly Fee.'
                ])
                ->withInput();
        }
    }

    Fee::create([
        'class_id'    => $request->class_id,
        'fee_type_id' => $request->fee_type_id,
        'amount'      => $request->amount,
    ]);

    return redirect()
        ->route('fees.index')
        ->with('success', 'Fee Added Successfully.');
}

public function show(Fee $fee)
{
    return view('fees.show', compact('fee'));
}

public function edit(Fee $fee)
{
    $classes = StudentClass::all();

    return view('fees.edit', compact('fee', 'classes'));
}

public function update(Request $request, Fee $fee)
{
    $request->validate([
        'class_id'    => 'required',
        'fee_type_id' => 'required',
        'amount'      => 'required|numeric',
    ]);

    $fee->update([
        'class_id'    => $request->class_id,
        'fee_type_id' => $request->fee_type_id,
        'amount'      => $request->amount,
    ]);

    return redirect()
        ->route('fees.index')
        ->with('success', 'Fee Updated Successfully.');
}
public function destroy(Fee $fee)
{
    $fee->delete();

    return redirect()->route('fees.index')
        ->with('success', 'Fee Deleted Successfully.');
}
}