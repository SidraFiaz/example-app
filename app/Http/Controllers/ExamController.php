<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Session;
use Illuminate\Http\Request;

class ExamController extends Controller
{
   public function index(Request $request)
{
    $session = null;

    if ($request->filled('session_id')) {
        $session = Session::findOrFail($request->session_id);

        $exams = Exam::where('session_id', $session->id)
            ->latest()
            ->get();
    } else {
        $exams = Exam::with('session')
            ->latest()
            ->get();
    }

    return view('exams.index', compact('exams', 'session'));
}

    public function create(Request $request)
{
    $sessions = Session::orderBy('name')->get();

    $session = null;

    if ($request->filled('session_id')) {
        $session = Session::findOrFail($request->session_id);
    }

    return view('exams.create', compact('sessions', 'session'));
}

public function edit(Exam $exam)
{
    $sessions = Session::orderBy('name')->get();

    $session = $exam->session;

    return view('exams.edit', compact('exam', 'sessions', 'session'));
}

public function update(Request $request, Exam $exam)
{
    $validated = $request->validate([
        'session_id'  => 'required|exists:academic_sessions,id',
        'exam_name'   => 'required|string|max:255',
        'total_marks' => 'required|integer|min:1',
        'start_date'  => 'required|date',
        'end_date'    => 'required|date|after_or_equal:start_date',
        'remarks'     => 'nullable|string',
    ]);

    $exam->update($validated);

    return redirect()
        ->route('exams.index', [
            'session_id' => $exam->session_id
        ])
        ->with('success', 'Exam updated successfully.');
}
    public function store(Request $request)
    {
        $validated = $request->validate([
            'session_id'   => 'required|exists:academic_sessions,id',
            'exam_name'    => 'required|string|max:255',
            'total_marks'  => 'required|integer|min:1',
            'start_date'   => 'required|date',
            'end_date'     => 'required|date|after_or_equal:start_date',
            'remarks'      => 'nullable|string',
        ]);

        Exam::create($validated);

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam Created Successfully');
    }

    public function destroy(Exam $exam)
    {
        $exam->delete();

        return redirect()
            ->route('exams.index')
            ->with('success', 'Exam deleted successfully.');
    }
}