<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }

    public function create()
    {
        return view('student.create');
    }

    public function store(Request $request)
    {
        Student::create([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'gender' => $request->gender,
        ]);

        return back()->with('success', 'Student saved successfully!');
    }

    // ================= EDIT =================

    public function edit(Student $student)
    {
        return view('student.edit', compact('student'));
    }

    // ================= UPDATE =================

    public function update(Request $request, Student $student)
    {
        $student->update([
            'name' => $request->name,
            'age' => $request->age,
            'email' => $request->email,
            'gender' => $request->gender,
        ]);

        return redirect()->route('student.index');
    }

    // ================= DELETE =================

    public function destroy(Student $student)
    {
        $student->delete();

        return redirect()->route('student.index');
    }
}