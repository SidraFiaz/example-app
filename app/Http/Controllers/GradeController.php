<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GradeController extends Controller
{
    /**
     * Display order matching the Grades screenshot:
     * A+ → A → B+ → B → C+ → C → D → E → F
     */
    private const GRADE_DISPLAY_ORDER = [
        'A+',
        'A',
        'B+',
        'B',
        'C+',
        'C',
        'D',
        'E',
        'F',
    ];

    /**
     * Default grades used only when creating missing seed rows.
     * Existing database records are never overwritten.
     */
    private const DEFAULT_GRADES = [
        [
            'grade_name' => 'A+',
            'remarks' => 'Excellent',
            'teacher_comment' => 'nice',
        ],
        [
            'grade_name' => 'A',
            'remarks' => 'v.good',
            'teacher_comment' => 'Keep up the incredible work!',
        ],
        [
            'grade_name' => 'B+',
            'remarks' => 'Good',
            'teacher_comment' => 'Continues to make progress in all academic areas due to hard work and determination.',
        ],
        [
            'grade_name' => 'B',
            'remarks' => 'Fair',
            'teacher_comment' => 'Regularly participates and contributes to class discussions.',
        ],
        [
            'grade_name' => 'C+',
            'remarks' => 'Satisfactory',
            'teacher_comment' => 'Satisfactory performance.',
        ],
        [
            'grade_name' => 'C',
            'remarks' => 'Normal',
            'teacher_comment' => 'Does not work up to potential.',
        ],
        [
            'grade_name' => 'D',
            'remarks' => 'Need to improve',
            'teacher_comment' => 'Fails to make up work.',
        ],
        [
            'grade_name' => 'E',
            'remarks' => 'Need work hard',
            'teacher_comment' => 'Fails to make up work.',
        ],
        [
            'grade_name' => 'F',
            'remarks' => 'Not Satisfactory',
            'teacher_comment' => 'Fails to make up work.',
        ],
    ];

    public function index()
    {
        $this->ensureDefaultGradesExist();

        $grades = $this->sortedGradesForDisplay(Grade::query()->get());

        return view('grades.index', compact('grades'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'grade_name' => 'required|string|max:255',
            'remarks' => 'required|string|max:255',
            'teacher_comment' => 'required|string',
        ]);

        $grade = Grade::create($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Grade Created Successfully',
                'grade' => [
                    'id' => $grade->id,
                    'grade_name' => $grade->grade_name,
                    'remarks' => $grade->remarks,
                    'teacher_comment' => $grade->teacher_comment,
                ],
            ]);
        }

        return redirect()
            ->route('grades.index')
            ->with('success', 'Grade Created Successfully');
    }

    public function update(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'grade_name' => 'required|string|max:255',
            'remarks' => 'required|string|max:255',
            'teacher_comment' => 'required|string',
        ]);

        $grade->update($validated);

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Grade Updated Successfully',
                'grade' => [
                    'id' => $grade->id,
                    'grade_name' => $grade->grade_name,
                    'remarks' => $grade->remarks,
                    'teacher_comment' => $grade->teacher_comment,
                ],
            ]);
        }

        return redirect()
            ->route('grades.index')
            ->with('success', 'Grade Updated Successfully');
    }

    public function destroy(Grade $grade)
    {
        $grade->delete();

        return redirect()
            ->route('grades.index')
            ->with('success', 'Grade Deleted Successfully');
    }

    /**
     * Insert only missing default grades. Never update or duplicate existing rows.
     */
    private function ensureDefaultGradesExist(): void
    {
        $existing = Grade::query()
            ->pluck('grade_name')
            ->map(fn ($name) => strtoupper(trim((string) $name)))
            ->all();

        $rows = [];

        foreach (self::DEFAULT_GRADES as $grade) {
            $key = strtoupper(trim($grade['grade_name']));

            if (in_array($key, $existing, true)) {
                continue;
            }

            $rows[] = [
                'grade_name' => $grade['grade_name'],
                'remarks' => $grade['remarks'],
                'teacher_comment' => $grade['teacher_comment'],
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $existing[] = $key;
        }

        if (! empty($rows)) {
            Grade::insert($rows);
        }
    }

    /**
     * Sort grades for listing in screenshot order.
     * Unknown grades fall back to percentage/marks (high → low), then name.
     */
    private function sortedGradesForDisplay(Collection $grades): Collection
    {
        $orderMap = array_flip(self::GRADE_DISPLAY_ORDER);

        return $grades
            ->sort(function ($a, $b) use ($orderMap) {
                $nameA = strtoupper(trim((string) $a->grade_name));
                $nameB = strtoupper(trim((string) $b->grade_name));

                $posA = $orderMap[$nameA] ?? null;
                $posB = $orderMap[$nameB] ?? null;

                if ($posA !== null && $posB !== null) {
                    return $posA <=> $posB;
                }

                if ($posA !== null) {
                    return -1;
                }

                if ($posB !== null) {
                    return 1;
                }

                $pctA = (float) ($a->percentage_to ?? $a->percentage_from ?? $a->max_marks ?? 0);
                $pctB = (float) ($b->percentage_to ?? $b->percentage_from ?? $b->max_marks ?? 0);

                if ($pctA !== $pctB) {
                    return $pctB <=> $pctA;
                }

                return strnatcasecmp($nameA, $nameB);
            })
            ->values();
    }
}
