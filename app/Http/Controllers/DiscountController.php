<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts = Discount::with([
            'studentClass',
            'student',
        ])->latest()->get();

        return view('discounts.index', compact('discounts'));
    }

    public function create()
    {
        $classes = StudentClass::all();
        $students = Student::with('studentClass')->get();

        return view('discounts.create', compact(
            'classes',
            'students'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount_type' => 'required|in:fixed,percentage',
            'discount_value' => 'required|numeric|min:0',
            'status' => 'required|in:Active,Inactive',
            'class_id' => 'nullable|exists:classes,id',
            'student_id' => 'nullable|exists:students,id',
        ]);

        if (!$request->class_id && !$request->student_id) {
            return back()
                ->withInput()
                ->withErrors([
                    'discount' => 'Please select either a class or a student.',
                ]);
        }

        if ($request->discount_type === 'percentage' && $request->discount_value > 100) {
            return back()
                ->withInput()
                ->withErrors([
                    'discount_value' => 'Percentage discount cannot be greater than 100%.',
                ]);
        }

        Discount::create([
            'class_id' => $request->class_id,
            'student_id' => $request->student_id,
            'discount_type' => $request->discount_type,
            'discount_value' => $request->discount_value,
            'status' => $request->status,
        ]);

        if ($request->input('return_to') === 'classes') {
            return redirect()
                ->route('classes')
                ->with('success', 'Discount Added Successfully.');
        }

        return redirect()
            ->route('discounts.index')
            ->with('success', 'Discount Added Successfully.');
    }

    public function destroy(Discount $discount)
    {
        $discount->delete();

        return redirect()
            ->route('discounts.index')
            ->with('success', 'Discount Deleted Successfully.');
    }
}