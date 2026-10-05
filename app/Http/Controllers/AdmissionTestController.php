<?php

namespace App\Http\Controllers;

use App\Models\AdmissionTest;
use App\Models\Session;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdmissionTestController extends Controller
{
    public function index()
    {
        $admissionTests = AdmissionTest::with([
            'studentClass',
            'session',
        ])
            ->latest()
            ->get();

        return view('admission-tests.index', compact('admissionTests'));
    }

    public function create()
    {
        $classes = StudentClass::orderBy('class_name')->get();
        $sessions = Session::orderBy('name')->get();

        return view('admission-tests.create', compact('classes', 'sessions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,id',
            'session_id' => 'required|exists:academic_sessions,id',
            'file' => 'nullable|file|max:10240',
        ]);

        $filePath = null;
        $fileName = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filePath = $file->store('admission-tests', 'public');
            $fileName = $file->getClientOriginalName();
        }

        AdmissionTest::create([
            'class_id' => $validated['class_id'],
            'session_id' => $validated['session_id'],
            'file_path' => $filePath,
            'file_name' => $fileName,
        ]);

        return redirect()
            ->route('admission-tests.index')
            ->with('success', 'Admission test saved successfully.');
    }

    public function print(AdmissionTest $admissionTest)
    {
        if (
            !$admissionTest->file_path ||
            !Storage::disk('public')->exists($admissionTest->file_path)
        ) {
            return redirect()
                ->route('admission-tests.index')
                ->with('error', 'No file available to print for this admission test.');
        }

        return response()->file(
            Storage::disk('public')->path($admissionTest->file_path)
        );
    }
}
