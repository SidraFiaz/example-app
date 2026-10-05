<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFee;
use Illuminate\Http\Request;

class PaperFundController extends Controller
{
    public function index(Request $request)
    {
        $query = AdmissionFee::with([
            'admission.studentClass',
            'admission.section',
        ])->where('type', 'Paper Fund');

        if ($request->filled('student')) {
            $search = $request->student;

            $query->whereHas('admission', function ($q) use ($search) {
                $q->where('student_name', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('family_no')) {
            $familyNo = $request->family_no;

            $query->whereHas('admission', function ($q) use ($familyNo) {
                $q->where('family_no', 'like', '%' . $familyNo . '%');
            });
        }

        $paperFunds = $query->latest()->get();

        return view('paper-funds.index', compact('paperFunds'));
    }
}
