<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Session;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentMark;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentMarksController extends Controller
{
    /**
     * View / Edit Student Marks — filter form + Students marks sheet after View Data.
     */
    public function index(Request $request)
    {
        $classes = StudentClass::orderBy('class_name')->get();
        $sessions = Session::orderBy('name')->get();
        $exams = Exam::orderBy('exam_name')->get();
        $currentDate = now()->format('Y-m-d');
        $activeSession = Session::where('is_active', true)->first();

        $sheetStudents = collect();
        $showResults = false;
        $sheetSubjectName = null;
        $sheetTotalMarks = null;

        if ($request->boolean('view_data')) {
            $request->validate([
                'class_id'     => 'required|exists:classes,id',
                'exam_id'      => 'required|exists:exams,id',
                'section_id'   => 'required|exists:sections,id',
                'subject_id'   => 'required|exists:subjects,id',
                'session_id'   => 'nullable|exists:academic_sessions,id',
                'student_id'   => 'nullable|exists:students,id',
                'current_date' => 'nullable|date',
            ]);

            $showResults = true;

            $subject = Subject::findOrFail($request->subject_id);
            $sheetSubjectName = $subject->subject_name;

            if ((int) $subject->class_id !== (int) $request->class_id) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'subject_id' => 'Selected subject does not belong to the selected class.',
                    ]);
            }

            $query = Student::query()
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id);

            if ($request->filled('student_id')) {
                $query->where('id', $request->student_id);
            }

            $students = $query->orderBy('name')->get(['id', 'name', 'class_id', 'section_id']);
            $sessionId = $request->input('session_id');

            $existing = StudentMark::query()
                ->where('exam_id', $request->exam_id)
                ->where('class_id', $request->class_id)
                ->where('section_id', $request->section_id)
                ->where('subject_id', $request->subject_id)
                ->whereIn('student_id', $students->pluck('id'))
                ->when(
                    $sessionId,
                    fn ($q) => $q->where('session_id', $sessionId),
                    fn ($q) => $q->whereNull('session_id')
                )
                ->get()
                ->keyBy('student_id');

            // Prefer a saved total_marks from existing records (form no longer collects it).
            $sheetTotalMarks = optional($existing->first())->total_marks;

            $sheetStudents = $students->map(function ($student) use ($subject, $existing) {
                $mark = $existing->get($student->id);

                return [
                    'id' => $student->id,
                    'name' => $student->name,
                    'subject_id' => $subject->id,
                    'subject_name' => $subject->subject_name,
                    'total_marks' => $mark ? (float) $mark->total_marks : null,
                    'obtained_marks' => $mark ? (float) $mark->obtained_marks : null,
                    'mark_id' => $mark?->id,
                ];
            })->values();
        }

        return view('student-marks.index', compact(
            'classes',
            'sessions',
            'exams',
            'currentDate',
            'activeSession',
            'sheetStudents',
            'sheetSubjectName',
            'sheetTotalMarks',
            'showResults'
        ));
    }

    /**
     * Main Student Marks page (selection + marks sheet).
     */
    public function create()
    {
        $classes = StudentClass::orderBy('class_name')->get();
        $exams = Exam::orderBy('exam_name')->get();
        $activeSession = Session::where('is_active', true)->first();
        $currentDate = now()->format('Y-m-d');

        return view('student-marks.create', compact(
            'classes',
            'exams',
            'activeSession',
            'currentDate'
        ));
    }

    /**
     * AJAX: students available for marks entry (excludes already-recorded combinations).
     */
    public function sheetStudents(Request $request)
    {
        $request->validate([
            'exam_id'      => 'required|exists:exams,id',
            'class_id'     => 'required|exists:classes,id',
            'section_id'   => 'required|exists:sections,id',
            'subject_id'   => 'required|exists:subjects,id',
            'student_id'   => 'nullable|exists:students,id',
            'session_id'   => 'nullable|exists:academic_sessions,id',
            'total_marks'  => 'required|numeric|min:0.01',
        ]);

        $subject = Subject::findOrFail($request->subject_id);

        if ((int) $subject->class_id !== (int) $request->class_id) {
            return response()->json([
                'message' => 'Selected subject does not belong to the selected class.',
                'students' => [],
                'already_recorded' => [],
            ], 422);
        }

        $query = Student::query()
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id);

        if ($request->filled('student_id')) {
            $query->where('id', $request->student_id);
        }

        $students = $query->orderBy('name')->get(['id', 'name', 'class_id', 'section_id']);

        $sessionId = $request->input('session_id');
        $enteredTotalMarks = (float) $request->input('total_marks');

        $existing = StudentMark::query()
            ->where('exam_id', $request->exam_id)
            ->where('class_id', $request->class_id)
            ->where('section_id', $request->section_id)
            ->where('subject_id', $request->subject_id)
            ->whereIn('student_id', $students->pluck('id'))
            ->when(
                $sessionId,
                fn ($q) => $q->where('session_id', $sessionId),
                fn ($q) => $q->whereNull('session_id')
            )
            ->get()
            ->keyBy('student_id');

        if ($request->filled('student_id') && $existing->has((int) $request->student_id)) {
            $student = $students->firstWhere('id', (int) $request->student_id);

            return response()->json([
                'message' => 'Marks already recorded for this student'
                    .($student ? ' ('.$student->name.').' : '.'),
                'students' => [],
                'already_recorded' => [[
                    'id' => (int) $request->student_id,
                    'name' => $student->name ?? '',
                ]],
            ], 422);
        }

        $alreadyRecorded = [];
        $available = [];

        foreach ($students as $student) {
            if ($existing->has($student->id)) {
                $alreadyRecorded[] = [
                    'id' => $student->id,
                    'name' => $student->name,
                ];
                continue;
            }

            $available[] = [
                'id' => $student->id,
                'name' => $student->name,
                'subject_id' => $subject->id,
                'subject_name' => $subject->subject_name,
                'total_marks' => $enteredTotalMarks,
                'obtained_marks' => null,
                'mark_id' => null,
                'already_recorded' => false,
            ];
        }

        return response()->json([
            'subject_name' => $subject->subject_name,
            'total_marks' => $enteredTotalMarks,
            'students' => $available,
            'already_recorded' => $alreadyRecorded,
        ]);
    }

    public function getStudents(Request $request, $class_id)
    {
        $query = Student::where('class_id', $class_id);

        if ($request->filled('section_id')) {
            $query->where('section_id', $request->section_id);
        }

        $students = $query->orderBy('name')->get(['id', 'name', 'class_id', 'section_id']);

        $recordedIds = collect();

        if (
            $request->filled('exam_id')
            && $request->filled('section_id')
            && $request->filled('subject_id')
        ) {
            $sessionId = $request->input('session_id');

            $recordedIds = StudentMark::query()
                ->where('exam_id', $request->exam_id)
                ->where('class_id', $class_id)
                ->where('section_id', $request->section_id)
                ->where('subject_id', $request->subject_id)
                ->whereIn('student_id', $students->pluck('id'))
                ->when(
                    $sessionId,
                    fn ($q) => $q->where('session_id', $sessionId),
                    fn ($q) => $q->whereNull('session_id')
                )
                ->pluck('student_id');
        }

        $payload = $students->map(function ($student) use ($recordedIds) {
            $alreadyRecorded = $recordedIds->contains($student->id);

            return [
                'id' => $student->id,
                'name' => $student->name,
                'class_id' => $student->class_id,
                'section_id' => $student->section_id,
                'already_recorded' => $alreadyRecorded,
            ];
        })->values();

        return response()->json($payload);
    }

    public function getSubjects($class_id)
    {
        return response()->json(
            Subject::where('class_id', $class_id)
                ->orderBy('subject_name')
                ->get(['id', 'subject_name', 'class_id'])
        );
    }

    /**
     * Save marks sheet (bulk upsert for entered obtained marks).
     */
    public function storeSheet(Request $request)
    {
        $validated = $request->validate([
            'exam_id'      => 'required|exists:exams,id',
            'class_id'     => 'required|exists:classes,id',
            'section_id'   => 'required|exists:sections,id',
            'subject_id'   => 'required|exists:subjects,id',
            'session_id'   => 'nullable|exists:academic_sessions,id',
            'date'         => 'nullable|date',
            'total_marks'  => [
                \Illuminate\Validation\Rule::requiredIf(
                    ($request->input('return_to') ?? 'create') !== 'index'
                ),
                'nullable',
                'numeric',
                'min:0.01',
            ],
            'marks'        => 'required|array|min:1',
            'marks.*.student_id' => 'required|exists:students,id',
            'marks.*.obtained_marks' => 'nullable|numeric|min:0',
            'marks.*.total_marks' => 'nullable|numeric|min:0.01',
            'return_to'    => 'nullable|in:index,create',
        ]);

        $subject = Subject::findOrFail($validated['subject_id']);
        $sessionId = $validated['session_id'] ?? null;
        $date = $validated['date'] ?? now()->toDateString();
        $sheetTotal = isset($validated['total_marks']) && $validated['total_marks'] !== null && $validated['total_marks'] !== ''
            ? (float) $validated['total_marks']
            : null;

        $saved = 0;
        $errors = [];

        DB::transaction(function () use (
            $validated,
            $subject,
            $sessionId,
            $date,
            $sheetTotal,
            &$saved,
            &$errors
        ) {
            foreach ($validated['marks'] as $index => $row) {
                if (! array_key_exists('obtained_marks', $row) || $row['obtained_marks'] === null || $row['obtained_marks'] === '') {
                    continue;
                }

                $obtained = (float) $row['obtained_marks'];
                $total = isset($row['total_marks']) && $row['total_marks'] !== null && $row['total_marks'] !== ''
                    ? (float) $row['total_marks']
                    : $sheetTotal;

                if ($total === null || $total <= 0) {
                    $errors["marks.$index.total_marks"] = 'Total Marks must be greater than 0.';
                    continue;
                }

                if ($obtained < 0) {
                    $errors["marks.$index.obtained_marks"] = 'Obtained Marks cannot be negative.';
                    continue;
                }

                if ($obtained > $total) {
                    $errors["marks.$index.obtained_marks"] = 'Obtained Marks cannot be greater than Total Marks.';
                    continue;
                }

                $student = Student::find($row['student_id']);
                if (
                    ! $student
                    || (int) $student->class_id !== (int) $validated['class_id']
                    || (int) $student->section_id !== (int) $validated['section_id']
                ) {
                    $errors["marks.$index.student_id"] = 'Invalid student for selected class/section.';
                    continue;
                }

                if ((int) $subject->class_id !== (int) $validated['class_id']) {
                    $errors["marks.$index.student_id"] = 'Subject does not belong to the selected class.';
                    continue;
                }

                $query = StudentMark::query()
                    ->where('student_id', $student->id)
                    ->where('exam_id', $validated['exam_id'])
                    ->where('class_id', $validated['class_id'])
                    ->where('section_id', $validated['section_id'])
                    ->where('subject_id', $validated['subject_id'])
                    ->when(
                        $sessionId,
                        fn ($q) => $q->where('session_id', $sessionId),
                        fn ($q) => $q->whereNull('session_id')
                    );

                $existing = $query->first();

                if ($existing) {
                    $errors["marks.$index.obtained_marks"] =
                        'Marks already recorded for this student ('.$student->name.').';
                    continue;
                }

                try {
                    StudentMark::create([
                        'exam_id' => $validated['exam_id'],
                        'student_id' => $student->id,
                        'class_id' => $validated['class_id'],
                        'section_id' => $validated['section_id'],
                        'subject_id' => $validated['subject_id'],
                        'session_id' => $sessionId,
                        'date' => $date,
                        'total_marks' => $total,
                        'obtained_marks' => $obtained,
                    ]);
                } catch (\Illuminate\Database\UniqueConstraintViolationException $e) {
                    $errors["marks.$index.obtained_marks"] =
                        'Marks already recorded for this student ('.$student->name.').';
                    continue;
                }

                $saved++;
            }
        });

        if (! empty($errors)) {
            $duplicateCount = collect($errors)
                ->filter(fn ($message) => str_contains((string) $message, 'Marks already recorded'))
                ->count();

            $errorFlash = $duplicateCount > 0
                ? ($duplicateCount === 1
                    ? 'Marks record already exists for one or more selected students.'
                    : 'Marks already recorded for '.$duplicateCount.' student(s). Duplicate records were not saved.')
                : 'Some marks could not be saved. Please check the validation messages.';

            return back()
                ->withInput()
                ->withErrors($errors)
                ->with('error', $errorFlash);
        }

        if ($saved === 0) {
            return back()
                ->withInput()
                ->withErrors([
                    'marks' => 'Please enter Obtained Marks for at least one student before saving.',
                ]);
        }

        $message = $saved.' student mark(s) saved successfully.';

        if (($validated['return_to'] ?? 'create') === 'index') {
            return redirect()
                ->route('student-marks.index', array_filter([
                    'view_data' => 1,
                    'current_date' => $validated['date'] ?? now()->toDateString(),
                    'session_id' => $sessionId,
                    'exam_id' => $validated['exam_id'],
                    'class_id' => $validated['class_id'],
                    'section_id' => $validated['section_id'],
                    'subject_id' => $validated['subject_id'],
                    'student_id' => $request->input('filter_student_id'),
                ], fn ($value) => $value !== null && $value !== ''))
                ->with('success', $message);
        }

        return redirect()
            ->route('student-marks.create')
            ->with('success', $message);
    }

    public function edit(StudentMark $studentMark)
    {
        $studentMark->load([
            'exam',
            'student',
            'studentClass',
            'section',
            'subject',
            'session',
        ]);

        return view('student-marks.edit', compact('studentMark'));
    }

    public function update(Request $request, StudentMark $studentMark)
    {
        $validated = $request->validate([
            'total_marks'    => 'required|numeric|min:0.01',
            'obtained_marks' => 'required|numeric|min:0',
        ]);

        if ((float) $validated['obtained_marks'] > (float) $validated['total_marks']) {
            return back()
                ->withInput()
                ->withErrors([
                    'obtained_marks' => 'Obtained Marks cannot be greater than Total Marks.',
                ]);
        }

        $studentMark->update([
            'total_marks'    => $validated['total_marks'],
            'obtained_marks' => $validated['obtained_marks'],
        ]);

        return redirect()
            ->route('student-marks.index')
            ->with('success', 'Student marks updated successfully.');
    }

    public function destroy(Request $request, StudentMark $studentMark)
    {
        $studentMark->delete();

        if ($request->boolean('return_sheet')) {
            return redirect()
                ->route('student-marks.index', array_filter([
                    'view_data' => 1,
                    'current_date' => $request->input('current_date'),
                    'session_id' => $request->input('session_id'),
                    'exam_id' => $request->input('exam_id'),
                    'class_id' => $request->input('class_id'),
                    'section_id' => $request->input('section_id'),
                    'subject_id' => $request->input('subject_id'),
                    'student_id' => $request->input('student_id'),
                ], fn ($value) => $value !== null && $value !== ''))
                ->with('success', 'Student marks deleted successfully.');
        }

        return redirect()
            ->route('student-marks.index')
            ->with('success', 'Student marks deleted successfully.');
    }
}
