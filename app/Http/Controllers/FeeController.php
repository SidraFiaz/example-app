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

    $fees = Fee::with(['feeType', 'studentClass'])
        ->whereNotNull('description')
        ->where('description', '!=', '')
        ->whereNotIn('description', ['Fee', 'Discount'])
        ->when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%'.$search.'%')
                    ->orWhere('amount', 'like', '%'.$search.'%')
                    ->orWhereHas('feeType', function ($typeQuery) use ($search) {
                        $typeQuery->where('fee_name', 'like', '%'.$search.'%');
                    });
            });
        })
        ->latest()
        ->get();

    return view('fees.index', compact('fees', 'search'));
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
    $feeType = FeeType::find($request->fee_type_id);
    $feeTypeName = strtolower(trim((string) optional($feeType)->fee_name));
    $isFee = $feeTypeName === 'fee';
    $isDiscount = $feeTypeName === 'discount';

    $rules = [
        'description' => 'required|string|max:255',
        'fee_type_id' => 'required',
        'class_id'    => 'nullable',
        'is_adjustment' => 'nullable',
    ];

    if ($isFee) {
        $rules['amount'] = 'required|numeric|min:0';
    } elseif ($isDiscount) {
        $rules['discount_type'] = 'required|in:amount,percentage,fixed';
        $rules['discount_value'] = 'required|numeric|min:0';
    } else {
        $rules['amount'] = 'nullable|numeric';
    }

    $request->validate($rules);

    $classId = $request->class_id ?: StudentClass::query()->value('id');

    if (! $classId) {
        return redirect()->back()
            ->withErrors([
                'description' => 'Please create a class before adding a fee.',
            ])
            ->withInput();
    }

    // Sirf Monthly Fee ek hi baar allow hogi
    if ($request->fee_type_id == 2) {

        $exists = Fee::where('class_id', $classId)
            ->where('fee_type_id', 2)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withErrors([
                    'fee_type_id' => 'This class already has a Monthly Fee.'
                ])
                ->withInput();
        }
    }

    $payload = [
        'description' => $request->description,
        'class_id'    => $classId,
        'fee_type_id' => $request->fee_type_id,
        'is_adjustment' => $request->boolean('is_adjustment'),
    ];

    if ($isDiscount) {
        $payload['discount_type'] = $request->discount_type;
        $payload['discount_value'] = $request->discount_value;
        $payload['amount'] = $request->discount_value ?? 0;
        $payload['fee_type'] = 'Normal';
    } else {
        $payload['amount'] = $request->amount ?? 0;
        $payload['fee_type'] = 'Normal';
        $payload['discount_type'] = null;
        $payload['discount_value'] = null;
    }

    Fee::create($payload);

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
    $fee->load('feeType');
    $feeTypes = FeeType::all();

    return view('fees.edit', compact('fee', 'feeTypes'));
}

public function update(Request $request, Fee $fee)
{
    $feeType = FeeType::find($request->fee_type_id);
    $feeTypeName = strtolower(trim((string) optional($feeType)->fee_name));
    $isFee = $feeTypeName === 'fee';
    $isDiscount = $feeTypeName === 'discount';

    $rules = [
        'description' => 'required|string|max:255',
        'fee_type_id' => 'required',
        'is_adjustment' => 'nullable',
    ];

    if ($isFee) {
        $rules['amount'] = 'required|numeric|min:0';
    } elseif ($isDiscount) {
        $rules['discount_type'] = 'required|in:amount,percentage,fixed';
        $rules['discount_value'] = 'required|numeric|min:0';
    } else {
        $rules['amount'] = 'nullable|numeric';
    }

    $request->validate($rules);

    $payload = [
        'description' => $request->description,
        'fee_type_id' => $request->fee_type_id,
        'is_adjustment' => $request->boolean('is_adjustment'),
    ];

    if ($isDiscount) {
        $payload['discount_type'] = $request->discount_type;
        $payload['discount_value'] = $request->discount_value;
        $payload['amount'] = $request->discount_value ?? 0;
    } else {
        $payload['amount'] = $request->amount ?? 0;
        $payload['discount_type'] = null;
        $payload['discount_value'] = null;
    }

    $fee->update($payload);

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