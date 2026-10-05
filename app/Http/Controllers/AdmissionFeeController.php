<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\AdmissionFee;
use Illuminate\Http\Request;

class AdmissionFeeController extends Controller
{
    public function create(Admission $admission)
    {
        $admissionFees = $admission->admissionFees()
            ->latest()
            ->get();

        return view('admission.fees', compact(
            'admission',
            'admissionFees'
        ));
    }

    public function store(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'paper_fund' => 'nullable|numeric|min:0',
            'prospectus' => 'nullable|numeric|min:0',
            'arrears_opening' => 'nullable|numeric|min:0',
            'registration_fee' => 'nullable|numeric|min:0',
            'security_fee' => 'nullable|numeric|min:0',
            'annual_charges' => 'nullable|numeric|min:0',
            'admission_charges' => 'nullable|numeric|min:0',
        ]);

        $fees = [
            'Paper Fund' => $validated['paper_fund'] ?? null,
            'Prospectus' => $validated['prospectus'] ?? null,
            'Arrears Opening' => $validated['arrears_opening'] ?? null,
            'Registration fee' => $validated['registration_fee'] ?? null,
            'Security Fee' => $validated['security_fee'] ?? null,
            'Annual Charges' => $validated['annual_charges'] ?? null,
            'ADMISSION CHARGES' => $validated['admission_charges'] ?? null,
        ];

        foreach ($fees as $type => $amount) {

            if ($amount !== null && $amount !== '') {

                AdmissionFee::create([
                    'admission_id' => $admission->id,
                    'type' => $type,
                    'amount' => $amount,
                ]);
            }
        }

        return redirect()
            ->route('admission-fees.create', $admission->id)
            ->with('success', 'Admission fee added successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Update Admission Fee
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, AdmissionFee $admissionFee)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $admissionFee->update([
            'amount' => $validated['amount'],
        ]);

        return redirect()
            ->route(
                'admission-fees.create',
                $admissionFee->admission_id
            )
            ->with('success', 'Admission fee updated successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Admission Fee
    |--------------------------------------------------------------------------
    */

    public function destroy(AdmissionFee $admissionFee)
    {
        $admissionFee->delete();

        return back()->with(
            'success',
            'Admission fee deleted successfully.'
        );
    }
}