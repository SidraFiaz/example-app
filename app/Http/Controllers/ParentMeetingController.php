<?php

namespace App\Http\Controllers;

use App\Models\ParentMeeting;
use App\Models\Student;
use Illuminate\Http\Request;

class ParentMeetingController extends Controller
{
    public function index()
    {
        $meetings = ParentMeeting::with([
            'student.studentClass',
        ])
            ->latest()
            ->get();

        $students = Student::with('studentClass')
            ->orderBy('name')
            ->get();

        return view('parent-meetings.index', compact('meetings', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'meeting_date' => 'nullable|date',
            'purpose' => 'nullable|string|max:255',
        ]);

        $validated['meeting_attend'] = 'Pending';

        ParentMeeting::create($validated);

        return redirect()
            ->route('parent-meetings.index')
            ->with('success', 'Parent meeting saved successfully.');
    }

    public function edit(ParentMeeting $parentMeeting)
    {
        $students = Student::with('studentClass')
            ->orderBy('name')
            ->get();

        return view('parent-meetings.edit', compact('parentMeeting', 'students'));
    }

    public function update(Request $request, ParentMeeting $parentMeeting)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'meeting_date' => 'nullable|date',
            'purpose' => 'nullable|string|max:255',
            'meeting_attend' => 'nullable|in:Pending,Yes,No',
        ]);

        $parentMeeting->update($validated);

        return redirect()
            ->route('parent-meetings.index')
            ->with('success', 'Parent meeting updated successfully.');
    }

    public function destroy(ParentMeeting $parentMeeting)
    {
        $parentMeeting->delete();

        return redirect()
            ->route('parent-meetings.index')
            ->with('success', 'Parent meeting deleted successfully.');
    }
}
