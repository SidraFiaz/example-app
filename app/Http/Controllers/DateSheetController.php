<?php

namespace App\Http\Controllers;

use App\Models\DateSheet;
use App\Models\Exam;
use App\Models\Session;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class DateSheetController extends Controller
{
    public function index()
    {
        $dateSheets = DateSheet::with([
            'exam',
            'studentClass',
            'session',
        ])
            ->latest()
            ->get();

        return view('date-sheets.index', compact('dateSheets'));
    }

    public function create()
    {
        $activeSession = Session::where('is_active', true)->first();
        $sessions = Session::orderBy('name')->get();
        $exams = Exam::orderBy('exam_name')->get();
        $classes = StudentClass::orderBy('class_name')->get();

        return view('date-sheets.create', compact(
            'activeSession',
            'sessions',
            'exams',
            'classes'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:academic_sessions,id',
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        DateSheet::create($validated);

        return redirect()
            ->route('date-sheets.index')
            ->with('success', 'Date sheet created successfully.');
    }

    public function edit(DateSheet $dateSheet)
    {
        $sessions = Session::orderBy('name')->get();
        $exams = Exam::orderBy('exam_name')->get();
        $classes = StudentClass::orderBy('class_name')->get();

        return view('date-sheets.edit', compact(
            'dateSheet',
            'sessions',
            'exams',
            'classes'
        ));
    }

    public function update(Request $request, DateSheet $dateSheet)
    {
        $validated = $request->validate([
            'session_id' => 'required|exists:academic_sessions,id',
            'exam_id' => 'required|exists:exams,id',
            'class_id' => 'required|exists:classes,id',
        ]);

        $dateSheet->update($validated);

        return redirect()
            ->route('date-sheets.index')
            ->with('success', 'Date sheet updated successfully.');
    }
}
