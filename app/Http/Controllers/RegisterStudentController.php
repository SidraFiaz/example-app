<?php

namespace App\Http\Controllers;

use App\Models\RegisterStudent;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class RegisterStudentController extends Controller
{
    public function index(Request $request)
    {
        $query = RegisterStudent::with([
            'student',
            'studentClass',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('admission_no', 'like', '%' . $search . '%')
                    ->orWhere('admission_no_2', 'like', '%' . $search . '%')
                    ->orWhere('form_no', 'like', '%' . $search . '%')
                    ->orWhere('registration_no', 'like', '%' . $search . '%')
                    ->orWhere('roll_no', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function ($studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('father_name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $registerStudents = $query->latest()->get();
        $classes = StudentClass::orderBy('class_name')->get();

        return view('register-students.index', compact(
            'registerStudents',
            'classes'
        ));
    }

    public function create()
    {
        $classes = StudentClass::orderBy('class_name')->get();
        $students = Student::with('studentClass')->orderBy('name')->get();

        return view('register-students.create', compact('classes', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $this->validatedData($request);

        RegisterStudent::create($validated);

        return redirect()
            ->route('register-students.index')
            ->with('success', 'Student registered successfully.');
    }

    public function edit(RegisterStudent $registerStudent)
    {
        $classes = StudentClass::orderBy('class_name')->get();

        $students = Student::with('studentClass')
            ->when($registerStudent->class_id, function ($query) use ($registerStudent) {
                $query->where('class_id', $registerStudent->class_id);
            })
            ->orderBy('name')
            ->get();

        return view('register-students.edit', compact(
            'registerStudent',
            'classes',
            'students'
        ));
    }

    public function update(Request $request, RegisterStudent $registerStudent)
    {
        $validated = $this->validatedData($request);

        $registerStudent->update($validated);

        return redirect()
            ->route('register-students.index')
            ->with('success', 'Registered student updated successfully.');
    }

    public function destroy(RegisterStudent $registerStudent)
    {
        $registerStudent->delete();

        return redirect()
            ->route('register-students.index')
            ->with('success', 'Registered student deleted successfully.');
    }

    public function export(Request $request)
    {
        $query = RegisterStudent::with([
            'student',
            'studentClass',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('admission_no', 'like', '%' . $search . '%')
                    ->orWhere('admission_no_2', 'like', '%' . $search . '%')
                    ->orWhere('form_no', 'like', '%' . $search . '%')
                    ->orWhere('registration_no', 'like', '%' . $search . '%')
                    ->orWhere('roll_no', 'like', '%' . $search . '%')
                    ->orWhereHas('student', function ($studentQuery) use ($search) {
                        $studentQuery->where('name', 'like', '%' . $search . '%')
                            ->orWhere('father_name', 'like', '%' . $search . '%');
                    });
            });
        }

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        $registerStudents = $query->latest()->get();

        $filename = 'register-students-9th-10th-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($registerStudents) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'Student Name',
                'Father Name',
                'Class',
                'Admission No',
                'Admission No 2',
                'Form No',
                'Registration No',
                'Roll No',
                'Obtain Marks',
                'Admission Date',
            ]);

            foreach ($registerStudents as $row) {
                fputcsv($handle, [
                    $row->student->name ?? '',
                    $row->student->father_name ?? '',
                    $row->studentClass->class_name ?? '',
                    $row->admission_no ?? '',
                    $row->admission_no_2 ?? '',
                    $row->form_no ?? '',
                    $row->registration_no ?? '',
                    $row->roll_no ?? '',
                    $row->obtain_marks ?? '',
                    $row->admission_date?->format('d-m-Y') ?? '',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    public function getStudents($classId)
    {
        $students = Student::where('class_id', $classId)
            ->orderBy('name')
            ->get(['id', 'name', 'father_name']);

        return response()->json($students);
    }

    protected function validatedData(Request $request): array
    {
        return $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'nullable|exists:students,id',
            'admission_no' => 'nullable|string|max:255',
            'admission_no_2' => 'nullable|string|max:255',
            'form_no' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:255',
            'roll_no' => 'nullable|string|max:255',
            'obtain_marks' => 'nullable|numeric|min:0',
            'admission_date' => 'nullable|date',
        ]);
    }
}
