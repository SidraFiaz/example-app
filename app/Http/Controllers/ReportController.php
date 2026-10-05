<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Section;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ReportController extends Controller
{
    public function index()
    {
        $reportTypes = collect($this->availableReports())
            ->filter(fn (array $report) => Route::has($report['route']))
            ->map(function (array $report) {
                $report['url'] = route($report['route']);

                return $report;
            })
            ->values()
            ->all();

        return view('reports.index', compact('reportTypes'));
    }

    /**
     * Exam PDF Report selection page.
     */
    public function examPdfReport()
    {
        $sessions = Session::orderByDesc('id')->get();
        // dd($sessions);

        $classes = StudentClass::orderBy('class_name')->get();

        return view('reports.exam-pdf-report', compact(
            'sessions',
            'classes'
        ));
    }

    /**
     * Get sections according to selected class.
     */
    public function examPdfReportSections($classId)
    {
        $sections = Section::where('class_id', $classId)
            ->orderBy('section_name')
            ->get(['id', 'section_name']);

        return response()->json($sections);
    }

    /**
     * Get exams according to selected session.
     */
    public function examPdfReportExams($sessionId)
    {
        $exams = Exam::where('session_id', $sessionId)
            ->orderByDesc('id')
            ->get(['id', 'exam_name']);

        return response()->json($exams);
    }

    /**
     * Get students according to selected class and section.
     */
    public function examPdfReportStudents(Request $request)
    {
        $query = Student::query();

        if ($request->filled('class_id')) {
            $query->where('class_id', $request->class_id);
        }

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        $students = $query
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($students);
    }

    /**
     * Report types backed by existing routes in this project.
     */
    protected function availableReports(): array
    {
        return [
            [
                'label' => 'Student Attendance Report',
                'route' => 'attendance.report',
                'keywords' => 'student attendance report',
                'group' => 'Student',
            ],

            [
                'label' => 'Search Student Attendance',
                'route' => 'attendance.search',
                'keywords' => 'student attendance search record',
                'group' => 'Student',
            ],

            [
                'label' => 'Student Admission Export',
                'route' => 'admission.export',
                'keywords' => 'student admission export csv listing data',
                'group' => 'Student',
            ],

            [
                'label' => 'Family Defaulter Report',
                'route' => 'fee-collections.family-defaulters',
                'keywords' => 'fee family defaulter report unpaid',
                'group' => 'Fee',
            ],

            [
                'label' => 'Exam PDF Report',
                'route' => 'exam-pdf-report.index',
                'keywords' => 'exam pdf report result marksheet examination',
                'group' => 'Exam',
            ],
        ];
    }
}