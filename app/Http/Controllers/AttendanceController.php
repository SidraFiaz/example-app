<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentClass;
use App\Models\Section;
use App\Models\Session;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Attendance Index
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        // Active academic session
        $session = Session::where('is_active', 1)->first();

        // All classes
        $classes = StudentClass::orderBy('class_name')->get();

        // Empty collections
        $sections = collect();
        $students = collect();

        // Selected class
        $selectedClass = $request->class_id;

        // Selected section
        $selectedSection = $request->section_id;

        /*
        |--------------------------------------------------------------------------
        | Get Sections According To Class
        |--------------------------------------------------------------------------
        */

        if ($selectedClass) {

            $sections = Section::where('class_id', $selectedClass)
                ->orderBy('section_name')
                ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Get Students According To Class + Section
        |--------------------------------------------------------------------------
        */

        if ($selectedClass && $selectedSection) {

            $students = Student::where('class_id', $selectedClass)
                ->where('section_id', $selectedSection)
                ->orderBy('name')
                ->get();
        }

        return view(
            'attendance.index',
            compact(
                'session',
                'classes',
                'sections',
                'students',
                'selectedClass',
                'selectedSection'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Save Attendance
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|integer',
            'section_id' => 'required|integer',
            'session_id' => 'required|integer',
            'date' => 'required|date',
            'attendance' => 'required|array',
        ]);

        foreach ($request->attendance as $student_id => $status) {

            Attendance::updateOrCreate(
                [
                    'student_id' => $student_id,
                    'attendance_date' => $request->date,
                ],
                [
                    'class_id' => $request->class_id,
                    'section_id' => $request->section_id,
                    'session_id' => $request->session_id,
                    'status' => $status,
                ]
            );
        }

        return redirect()
            ->route('attendance.index', [
                'class_id' => $request->class_id,
                'section_id' => $request->section_id,
            ])
            ->with('success', 'Attendance Saved Successfully');
    }


    /*
    |--------------------------------------------------------------------------
    | Attendance Report
    |--------------------------------------------------------------------------
    */

    public function report(Request $request)
    {
        // All classes
        $classes = StudentClass::orderBy('class_name')->get();

        // Empty collections
        $sections = collect();
        $students = collect();

        /*
        |--------------------------------------------------------------------------
        | Get Sections According To Selected Class
        |--------------------------------------------------------------------------
        */

        if ($request->filled('class_id')) {

            $sections = Section::where(
                'class_id',
                $request->class_id
            )
            ->orderBy('section_name')
            ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | Get Students
        |--------------------------------------------------------------------------
        */

        if (
            $request->filled('class_id') &&
            $request->filled('section_id')
        ) {

            $students = Student::where(
                'class_id',
                $request->class_id
            )
            ->where(
                'section_id',
                $request->section_id
            )
            ->orderBy('name')
            ->get();
        }

        /*
        |--------------------------------------------------------------------------
        | IMPORTANT:
        | If a student is selected, show ONLY that student
        |--------------------------------------------------------------------------
        */

        if ($request->filled('student_id')) {

            $students = $students->where(
                'id',
                (int) $request->student_id
            )->values();
        }

        return view(
            'attendance.report',
            compact(
                'classes',
                'sections',
                'students'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | AJAX: Get Sections For Attendance
    |--------------------------------------------------------------------------
    */

    public function getReportSections($class_id)
    {
        $sections = Section::where(
            'class_id',
            $class_id
        )
        ->orderBy('section_name')
        ->get();

        return response()->json($sections);
    }


    /*
    |--------------------------------------------------------------------------
    | AJAX: Get Students For Attendance Report
    |--------------------------------------------------------------------------
    */

    public function getReportStudents($section_id)
    {
        $students = Student::where(
            'section_id',
            $section_id
        )
        ->orderBy('name')
        ->get([
            'id',
            'name'
        ]);

        return response()->json($students);
    }

   public function search(Request $request)
{
    $session = Session::where('is_active', 1)->first();

    $classes = StudentClass::orderBy('class_name')->get();

    $sections = collect();
    $students = collect();

    if ($request->filled('class_id')) {

        $sections = Section::where(
            'class_id',
            $request->class_id
        )
        ->orderBy('section_name')
        ->get();
    }

    if (
        $request->filled('class_id') &&
        $request->filled('section_id')
    ) {

        $students = Student::where(
            'class_id',
            $request->class_id
        )
        ->where(
            'section_id',
            $request->section_id
        )
        ->orderBy('name')
        ->get();
    }

    return view(
        'attendance.search',
        compact(
            'session',
            'classes',
            'sections',
            'students'
        )
    );
}
}