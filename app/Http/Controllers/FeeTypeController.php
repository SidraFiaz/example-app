<?php

namespace App\Http\Controllers;

use App\Models\FeeType;
use Illuminate\Http\Request;

class FeeTypeController extends Controller
{
    /**
     * Fee Types shown on the Fee Types management page.
     */
    private const MANAGED_FEE_TYPES = ['Fee', 'Discount'];

    public function index(Request $request)
    {
        $this->ensureManagedFeeTypesExist();

        $search = trim((string) $request->get('search', ''));

        $feeTypes = FeeType::query()
            ->whereIn('fee_name', self::MANAGED_FEE_TYPES)
            ->when($search !== '', function ($query) use ($search) {
                $query->where('fee_name', 'like', '%'.$search.'%');
            })
            ->orderByRaw("FIELD(fee_name, 'Fee', 'Discount')")
            ->get();

        return view('fee-types.index', compact('feeTypes', 'search'));
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

        return redirect()
            ->route('fee-types.index')
            ->with('success', 'Fee Type Updated Successfully.');
    }

    private function ensureManagedFeeTypesExist(): void
    {
        FeeType::firstOrCreate(
            ['fee_name' => 'Fee'],
            ['is_adjustment' => false]
        );

        FeeType::firstOrCreate(
            ['fee_name' => 'Discount'],
            ['is_adjustment' => true]
        );
    }
}
