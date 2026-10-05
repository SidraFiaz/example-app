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
            'studentClass.classFees',
            'section'
        ])->get();

        return view('student.index', compact('students'));
    }


    // ================= CREATE =================

    public function create()
    {
        $classes = StudentClass::all();
        $sections = Section::all();

        return view(
            'student.create',
            compact('classes', 'sections')
        );
    }


    // ================= STORE =================

    public function store(Request $request)
    {
        $request->validate([

            'name' =>
                'required|string|max:255',

            'father_name' =>
                'nullable|string|max:255',

            'age' =>
                'required|integer',

            'email' =>
                'required|email',

            'gender' =>
                'required',

            'class_id' =>
                'required|exists:classes,id',

            'section_id' =>
                'required|exists:sections,id',
        ]);


        Student::create([

            'name' =>
                $request->name,

            'father_name' =>
                $request->father_name,

            'age' =>
                $request->age,

            'email' =>
                $request->email,

            'gender' =>
                $request->gender,

            'class_id' =>
                $request->class_id,

            'section_id' =>
                $request->section_id,
        ]);


        return back()
            ->with(
                'success',
                'Student saved successfully!'
            );
    }


    // ================= SHOW =================

    public function show(Student $student)
    {
        $student->load([
            'studentClass.classFees',
            'section',
            'feeCollections.feeType',
        ]);

        $classes = StudentClass::orderBy('class_name')->get();
        $sections = Section::orderBy('section_name')->get();

        $classFee = $student->studentClass?->classFees?->first();

        return view(
            'student.show',
            compact('student', 'classes', 'sections', 'classFee')
        );
    }


    // ================= EDIT =================

    public function edit(Student $student)
    {
        $classes = StudentClass::all();
        $sections = Section::all();

        return view(
            'student.edit',
            compact(
                'student',
                'classes',
                'sections'
            )
        );
    }


    // ================= UPDATE =================

    public function update(
        Request $request,
        Student $student
    ) {

        $request->validate([

            'name' =>
                'required|string|max:255',

            'father_name' =>
                'nullable|string|max:255',

            'age' =>
                'required|integer',

            'email' =>
                'required|email',

            'gender' =>
                'required',

            'class_id' =>
                'required|exists:classes,id',

            'section_id' =>
                'required|exists:sections,id',
        ]);


        $student->update([

            'name' =>
                $request->name,

            'father_name' =>
                $request->father_name,

            'age' =>
                $request->age,

            'email' =>
                $request->email,

            'gender' =>
                $request->gender,

            'class_id' =>
                $request->class_id,

            'section_id' =>
                $request->section_id,
        ]);


        return redirect()
            ->route('student.index')
            ->with(
                'success',
                'Student updated successfully!'
            );
    }


    // ================= DELETE =================

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()
            ->route('student.index')
            ->with(
                'success',
                'Student deleted successfully!'
            );
    }
}