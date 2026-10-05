<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
use App\Models\Fee;
use App\Models\FeeCollection;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdjustmentController extends Controller
{
    public function index()
    {
        $classes = StudentClass::orderBy('class_name')->get();

        $sections = Section::orderBy('section_name')->get();

        $adjustmentTypes = Fee::query()
            ->where('is_adjustment', true)
            ->whereNotNull('description')
            ->where('description', '!=', '')
            ->whereNotIn('description', ['Fee', 'Discount'])
            ->orderBy('description')
            ->get();

        $students = Student::orderBy('name')->get();

        $activeSession = Session::where('is_active', true)->first();
        $sessionMonths = $activeSession
            ? $activeSession->monthsInRange()
            : [];

        $fees = collect();
        $activeAdjustmentMonths = [];

        if (request()->student_id) {

            $fees = FeeCollection::with(['fee', 'feeType'])
                ->where('student_id', request()->student_id)
                ->where('remarks', 'Adjustment')
                ->orderByDesc('year')
                ->orderByDesc('month')
                ->orderByDesc('id')
                ->get();

            $activeAdjustmentMonths = $fees
                ->pluck('month')
                ->map(fn ($month) => (int) $month)
                ->unique()
                ->values()
                ->all();
        }

        return view('adjustment.index', compact(
            'classes',
            'students',
            'sections',
            'adjustmentTypes',
            'fees',
            'activeSession',
            'sessionMonths',
            'activeAdjustmentMonths'
        ));
    }


    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'month' => 'required|integer|min:1|max:12',
            'adjustments' => 'required|array|min:1',
            'adjustments.*.fee_id' => [
                'required',
                Rule::exists('fees', 'id')->where('is_adjustment', true),
            ],
            'adjustments.*.amount' => 'required|numeric|min:0',
        ]);


        foreach ($request->adjustments as $adjustment) {

            $fee = Fee::findOrFail($adjustment['fee_id']);

            FeeCollection::create([
                'student_id' => $request->student_id,
                'fee_type_id' => $fee->fee_type_id,
                'fee_id' => $fee->id,
                'amount' => $adjustment['amount'],
                'amount_paid' => $adjustment['amount'],
                'month' => $request->month,
                'year' => now()->year,
                'payment_date' => now()->toDateString(),
                'status' => 'Paid',
                'remarks' => 'Adjustment',
            ]);
        }


        return redirect()
            ->route('adjustment.index', [
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
                'student_id' => $request->student_id,
            ])
            ->with('success', 'Adjustments saved successfully.');
    }

    
}
