<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // Show all subjects with search
    public function index(Request $request)
    {
       $subjects = Subject::with('studentClass')->when($request->search, function ($query) use ($request) {
            $query->where('subject_name', 'like', '%' . $request->search . '%');
        })->paginate(10);

        return view('subjects.index', compact('subjects'));
    }

    // Show create form
    public function create()
    {
        $classes = StudentClass::all();

        return view('subjects.create', compact('classes'));
    }

    // Store subject
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_name' => 'required|max:255',
        ]);

        Subject::create([
            'class_id' => $request->class_id,
            'subject_name' => $request->subject_name,
        ]);

        return redirect()->route('subjects.index')
            ->with('success', 'Subject added successfully.');
    }

    // Show edit form
   public function edit(Subject $subject)
{
    $classes = StudentClass::all();

    return view('subjects.edit', compact('subject', 'classes'));
}

    // Update subject
   public function update(Request $request, Subject $subject)
{
    $request->validate([
        'class_id' => 'required|exists:classes,id',
        'subject_name' => 'required|max:255',
    ]);

    $subject->update([
        'class_id' => $request->class_id,
        'subject_name' => $request->subject_name,
    ]);

    return redirect()->route('subjects.index')
        ->with('success', 'Subject updated successfully.');
}
    // Delete subject
    public function destroy(Subject $subject)
    {
        $subject->delete();

        return redirect()->route('subjects.index')
            ->with('success', 'Subject deleted successfully.');
    }
}