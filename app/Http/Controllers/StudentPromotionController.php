<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentPromotion;
use Illuminate\Http\Request;


class StudentPromotionController extends Controller
{
    public function index()
    {
        $students = Student::with(['studentClass', 'section'])->get();
        $classes = StudentClass::all();

        return view('student-promotions.index', compact('students', 'classes'));
    }

    public function promote(Request $request, Student $student)
{
    $request->validate([
        'class_id' => 'required|exists:classes,id',
    ]);

    $fromClassId = $student->class_id;
    $toClassId = $request->class_id;

    StudentPromotion::create([
        'student_id' => $student->id,
        'from_class_id' => $fromClassId,
        'to_class_id' => $toClassId,
        'promotion_date' => now()->toDateString(),
    ]);

    $student->update([
        'class_id' => $toClassId,
    ]);

    return redirect()
        ->route('student-promotions.index')
        ->with('success', 'Student promoted successfully.');
}


public function history()
{
    $promotions = StudentPromotion::with([
        'student',
        'fromClass',
        'toClass'
    ])->latest()->get();

    return view('student-promotions.history', compact('promotions'));
}

}