<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;

class StudentController extends Controller
{
    // ================= INDEX =================

  public function index()
{
    $students = Student::with([
        'studentClass.fees',
        'section'
    ])->get();

    return view('student.index', compact('students'));
}
    // ================= CREATE =================
public function create()
{
    $classes = StudentClass::all();
    $sections = Section::all();

    return view('student.create', compact('classes', 'sections'));
}
    // ================= STORE =================
public function store(Request $request)
{
    Student::create([
        'name'       => $request->name,
        'age'        => $request->age,
        'email'      => $request->email,
        'gender'     => $request->gender,
        'class_id'   => $request->class_id,
        'section_id' => $request->section_id,
    ]);

    return back()->with('success', 'Student saved successfully!');
}

    // ================= SHOW (VIEW) =================

    public function show(Student $student)
{
   $student->load([
    'studentClass',
    'section'
]);
    return view('student.show', compact('student'));
}

    // ================= EDIT =================

   public function edit(Student $student)
{
    $classes = StudentClass::all();
    $sections = Section::all();

    return view('student.edit', compact('student', 'classes', 'sections'));
}
    // ================= UPDATE =================

   public function update(Request $request, Student $student)
{
    $student->update([
        'name'       => $request->name,
        'age'        => $request->age,
        'email'      => $request->email,
        'gender'     => $request->gender,
        'class_id'   => $request->class_id,
        'section_id' => $request->section_id,
    ]);

    return redirect()->route('student.index')
        ->with('success', 'Student updated successfully!');
}

    // ================= DELETE =================

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index')
            ->with('success', 'Student deleted successfully!');
    }
}