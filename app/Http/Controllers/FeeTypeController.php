<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    public function index()
    {
        $feeTypes = FeeType::latest()->get();

        return view('fee-types.index', compact('feeTypes'));
    }

    public function create()
    {
        return view('fee-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fee_name' => 'required|string|max:255',
        ]);

        FeeType::create([
            'fee_name' => $request->fee_name,
        ]);

        return redirect()->route('fee-types.index')
            ->with('success', 'Fee Type Added Successfully.');
    }

    public function edit(FeeType $fee_type)
    {
        return view('fee-types.edit', compact('fee_type'));
    }

    public function update(Request $request, FeeType $fee_type)
    {
        $request->validate([
            'fee_name' => 'required|string|max:255',
        ]);

        $fee_type->update([
            'fee_name' => $request->fee_name,
        ]);

        return redirect()->route('fee-types.index')
            ->with('success', 'Fee Type Updated Successfully.');
    }

    public function destroy(FeeType $fee_type)
    {
        $fee_type->delete();

        return redirect()->route('fee-types.index')
            ->with('success', 'Fee Type Deleted Successfully.');
    }
}