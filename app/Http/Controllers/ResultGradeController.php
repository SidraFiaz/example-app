<?php

namespace App\Http\Controllers;

use App\Models\ResultGrade;
use App\Models\Exam;
use App\Models\ClassGroup;
use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class ResultGradeController extends Controller
{
    /**
     * Preferred Grade dropdown order for Result Grades.
     */
    private const GRADE_DROPDOWN_ORDER = [
        'F',
        'E',
        'D',
        'C',
        'C+',
        'B',
        'B+',
        'A',
        'A+',
    ];

    public function index(Request $request)
    {
        $term = $request->get('term', 'First Term');

        $resultGrades = ResultGrade::where('term', $term)
            ->orderBy('id', 'desc')
            ->get();

        $exams = Exam::orderBy('id', 'desc')->get();

        $classGroups = ClassGroup::orderBy('id', 'desc')->get();

        $grades = $this->sortedGrades(Grade::query()->get());

        return view('result-grades.index', compact(
            'resultGrades',
            'exams',
            'classGroups',
            'grades',
            'term'
        ));
    }

    /**
     * AJAX: grades still available for Exam/Term + Class Group.
     */
    public function availableGrades(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_group' => 'required|string|max:255',
            'term' => 'required|in:First Term,2nd Term',
            'exclude_id' => 'nullable|integer|exists:result_grades,id',
        ]);

        $usedQuery = $this->usedGradesQuery(
            (int) $validated['exam_id'],
            $validated['class_group'],
            $validated['term']
        );

        if (! empty($validated['exclude_id'])) {
            $usedQuery->where('id', '!=', $validated['exclude_id']);
        }

        $usedGrades = $usedQuery
            ->pluck('grade')
            ->map(fn ($grade) => strtoupper(trim((string) $grade)))
            ->unique()
            ->values()
            ->all();

        $available = $this->sortedGrades(Grade::query()->get())
            ->filter(function ($grade) use ($usedGrades) {
                return ! in_array(strtoupper(trim((string) $grade->grade_name)), $usedGrades, true);
            })
            ->values()
            ->map(fn ($grade) => [
                'id' => $grade->id,
                'grade_name' => $grade->grade_name,
            ]);

        return response()->json([
            'grades' => $available,
            'all_created' => $available->isEmpty(),
            'message' => $available->isEmpty()
                ? 'All grades have already been created for this Exam and Class Group.'
                : null,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'exam_id' => 'required|exists:exams,id',
            'class_group' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'starting_percentage' => 'required|numeric|min:0|max:100',
            'ending_percentage' => 'required|numeric|min:0|max:100|gte:starting_percentage',
            'date' => 'nullable|date',
            'term' => 'nullable|in:First Term,2nd Term',
        ]);

        $exam = Exam::findOrFail($validated['exam_id']);
        $validated['term'] = $this->termFromExam($exam)
            ?? ($validated['term'] ?? 'First Term');
        $validated['date'] = $validated['date'] ?? now()->toDateString();

        $duplicate = $this->usedGradesQuery(
            (int) $validated['exam_id'],
            $validated['class_group'],
            $validated['term']
        )
            ->whereRaw('UPPER(TRIM(grade)) = ?', [strtoupper(trim($validated['grade']))])
            ->exists();

        if ($duplicate) {
            $message = 'This grade is already recorded for the selected Exam/Term and Class Group.';

            if ($request->expectsJson() || $request->ajax()) {
                throw ValidationException::withMessages([
                    'grade' => [$message],
                ]);
            }

            return back()
                ->withInput()
                ->withErrors([
                    'grade' => $message,
                ]);
        }

        $resultGrade = ResultGrade::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            session()->flash('success', 'Grade Created Successfully');

            return response()->json([
                'message' => 'Grade Created Successfully',
                'result_grade' => $resultGrade,
                'redirect' => route('result-grades.index', ['term' => $validated['term']]),
            ]);
        }

        return redirect()
            ->route('result-grades.index', ['term' => $validated['term']])
            ->with('success', 'Grade Created Successfully');
    }

    public function update(Request $request, ResultGrade $resultGrade)
    {
        $validated = $request->validate([
            'grade' => 'required|string|max:255',
            'starting_percentage' => 'required|numeric|min:0|max:100',
            'ending_percentage' => 'required|numeric|min:0|max:100|gte:starting_percentage',
        ]);

        $duplicate = $this->usedGradesQuery(
            (int) $resultGrade->exam_id,
            (string) $resultGrade->class_group,
            (string) $resultGrade->term
        )
            ->whereRaw('UPPER(TRIM(grade)) = ?', [strtoupper(trim($validated['grade']))])
            ->where('id', '!=', $resultGrade->id)
            ->exists();

        if ($duplicate) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'message' => 'This grade is already recorded for the selected Exam, Class Group and Term.',
                    'errors' => [
                        'grade' => ['This grade is already recorded for the selected Exam, Class Group and Term.'],
                    ],
                ], 422);
            }

            return back()
                ->withInput()
                ->withErrors([
                    'grade' => 'This grade is already recorded for the selected Exam, Class Group and Term.',
                ]);
        }

        // Only update editable fields; keep exam/class_group/term/date unchanged.
        $resultGrade->update([
            'grade' => $validated['grade'],
            'starting_percentage' => $validated['starting_percentage'],
            'ending_percentage' => $validated['ending_percentage'],
        ]);

        session()->flash('success', 'Grade Updated Successfully');

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'message' => 'Grade Updated Successfully',
                'result_grade' => $resultGrade->fresh(),
                'redirect' => route('result-grades.index', ['term' => $resultGrade->term]),
            ]);
        }

        return redirect()
            ->route('result-grades.index', ['term' => $resultGrade->term])
            ->with('success', 'Grade Updated Successfully');
    }

    public function destroy(ResultGrade $resultGrade)
    {
        $term = $resultGrade->term;

        $resultGrade->delete();

        return redirect()
            ->route('result-grades.index', ['term' => $term])
            ->with('success', 'Grade Deleted Successfully');
    }

    /**
     * Grades already used for this Exam/Term + Class Group.
     * Matches either the same exam_id or the same term so dropdown
     * filtering stays correct even when term/exam were previously out of sync.
     */
    private function usedGradesQuery(int $examId, string $classGroup, string $term)
    {
        return ResultGrade::query()
            ->where('class_group', $classGroup)
            ->where(function ($query) use ($examId, $term) {
                $query->where('exam_id', $examId)
                    ->orWhere('term', $term);
            });
    }

    /**
     * Map exam name (e.g. "Second Term") to Result Grades tab term.
     */
    private function termFromExam(Exam $exam): ?string
    {
        $name = strtolower(trim((string) ($exam->exam_name ?? $exam->name ?? '')));

        if ($name === '') {
            return null;
        }

        if (str_contains($name, '2nd') || str_contains($name, 'second')) {
            return '2nd Term';
        }

        if (str_contains($name, 'first')) {
            return 'First Term';
        }

        return null;
    }

    private function sortedGrades(Collection $grades): Collection
    {
        $orderMap = array_flip(self::GRADE_DROPDOWN_ORDER);

        return $grades
            ->sort(function ($a, $b) use ($orderMap) {
                $nameA = strtoupper(trim((string) $a->grade_name));
                $nameB = strtoupper(trim((string) $b->grade_name));

                $posA = $orderMap[$nameA] ?? 999;
                $posB = $orderMap[$nameB] ?? 999;

                if ($posA === $posB) {
                    return strnatcasecmp($nameA, $nameB);
                }

                return $posA <=> $posB;
            })
            ->values();
    }
}
