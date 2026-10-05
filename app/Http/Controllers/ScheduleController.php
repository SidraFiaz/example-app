<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Section;
use App\Models\StudentClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with([
            'studentClass',
            'section',
            'subject',
        ])
            ->latest()
            ->get();

        return view('schedules.index', compact('schedules'));
    }

    public function create()
    {
        $classes = StudentClass::orderBy('class_name')->get();
        $sections = Section::orderBy('section_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();

        return view('schedules.create', compact(
            'classes',
            'sections',
            'subjects'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'weekday' => 'required|string|max:50',
            'time_from' => 'nullable',
            'time_to' => 'nullable',
            'teacher_name' => 'nullable|string|max:255',
        ]);

        Schedule::create($validated);

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Schedule created successfully.');
    }

    public function show(Schedule $schedule)
    {
        $schedule->load([
            'studentClass',
            'section',
            'subject',
        ]);

        $classSchedules = Schedule::with([
            'section',
            'subject',
        ])
            ->where('class_id', $schedule->class_id)
            ->orderBy('weekday')
            ->orderBy('time_from')
            ->get();

        return view('schedules.show', compact('schedule', 'classSchedules'));
    }

    public function edit(Schedule $schedule)
    {
        $classes = StudentClass::orderBy('class_name')->get();
        $sections = Section::orderBy('section_name')->get();
        $subjects = Subject::orderBy('subject_name')->get();

        return view('schedules.edit', compact(
            'schedule',
            'classes',
            'sections',
            'subjects'
        ));
    }

    public function update(Request $request, Schedule $schedule)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'subject_id' => 'nullable|exists:subjects,id',
            'weekday' => 'required|string|max:50',
            'time_from' => 'nullable',
            'time_to' => 'nullable',
            'teacher_name' => 'nullable|string|max:255',
        ]);

        $schedule->update($validated);

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Schedule updated successfully.');
    }

    public function destroy(Schedule $schedule)
    {
        $schedule->delete();

        return redirect()
            ->route('schedules.index')
            ->with('success', 'Schedule deleted successfully.');
    }
}
