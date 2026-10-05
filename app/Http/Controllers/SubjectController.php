<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SubjectController extends Controller
{
    // Show subjects (optionally filtered by class)
    public function index(Request $request)
    {
        $classes = StudentClass::orderBy('class_name')->get();

        $subjects = Subject::with('studentClass')
            ->when($request->filled('class_id'), function ($query) use ($request) {
                $query->where('class_id', $request->class_id);
            })
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('subject_name', 'like', '%' . $request->search . '%');
            })
            ->orderBy('class_id')
            ->orderBy('subject_name')
            ->paginate(10)
            ->withQueryString();

        return view('subjects.index', compact('subjects', 'classes'));
    }

    // Show create form
    public function create(Request $request)
    {
        $classes = StudentClass::orderBy('class_name')->get();

        return view('subjects.create', compact('classes'));
    }

    // Store subject for the selected class only
    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_name' => [
                'required',
                'max:255',
                Rule::unique('subjects', 'subject_name')->where(function ($query) use ($request) {
                    return $query->where('class_id', $request->class_id);
                }),
            ],
        ]);

        Subject::create([
            'class_id' => $request->class_id,
            'subject_name' => $request->subject_name,
        ]);

        return redirect()
            ->route('subjects.index', ['class_id' => $request->class_id])
            ->with('success', 'Subject added successfully for the selected class.');
    }

    // Show edit form
    public function edit(Subject $subject)
    {
        $classes = StudentClass::orderBy('class_name')->get();

        return view('subjects.edit', compact('subject', 'classes'));
    }

    // Update subject (keep linked to a class)
    public function update(Request $request, Subject $subject)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'subject_name' => [
                'required',
                'max:255',
                Rule::unique('subjects', 'subject_name')
                    ->ignore($subject->id)
                    ->where(function ($query) use ($request) {
                        return $query->where('class_id', $request->class_id);
                    }),
            ],
        ]);

        $subject->update([
            'class_id' => $request->class_id,
            'subject_name' => $request->subject_name,
        ]);

        return redirect()
            ->route('subjects.index', ['class_id' => $request->class_id])
            ->with('success', 'Subject updated successfully.');
    }

    // Delete subject
    public function destroy(Request $request, Subject $subject)
    {
        $classId = $subject->class_id;
        $subject->delete();

        return redirect()
            ->route('subjects.index', array_filter(['class_id' => $request->input('class_id', $classId)]))
            ->with('success', 'Subject deleted successfully.');
    }
}
