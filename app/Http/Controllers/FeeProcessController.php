<?php

namespace App\Http\Controllers;

use App\Models\ClassFee;
use App\Models\FeeProcess;
use App\Models\Section;
use App\Models\Student;
use App\Models\StudentClass;
use App\Services\StudentMonthlyFeeCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FeeProcessController extends Controller
{
    public function index()
    {
        $classes = StudentClass::all();
        $students = Student::all();
        $sections = Section::all();

        $fees = FeeProcess::with([
            'student',
            'studentClass',
            'feeType',
        ])
            ->latest()
            ->get();

        return view('fee-process.index', compact(
            'classes',
            'students',
            'sections',
            'fees'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'session' => 'required|string',
            'month' => 'required|string',
            'class_id' => 'required|exists:classes,id',
            'section_id' => 'nullable|exists:sections,id',
            'student_id' => 'nullable|exists:students,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:issue_date',
        ]);

        $classId = (int) $request->class_id;
        $sectionId = $request->filled('section_id') ? (int) $request->section_id : null;
        $studentId = $request->filled('student_id') ? (int) $request->student_id : null;

        // Section must belong to the selected class
        if ($sectionId !== null) {
            $sectionBelongsToClass = Section::where('id', $sectionId)
                ->where('class_id', $classId)
                ->exists();

            if (! $sectionBelongsToClass) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'section_id' => 'The selected section does not belong to the selected class.',
                    ]);
            }
        }

        // Resolve target students
        if ($studentId !== null) {
            $studentQuery = Student::where('id', $studentId)
                ->where('class_id', $classId);

            if ($sectionId !== null) {
                $studentQuery->where('section_id', $sectionId);
            }

            $students = $studentQuery->get();

            if ($students->isEmpty()) {
                return back()
                    ->withInput()
                    ->withErrors([
                        'student_id' => 'The selected student does not belong to the selected class/section.',
                    ]);
            }
        } else {
            // Class only, or Class + Section → all matching students
            $studentQuery = Student::where('class_id', $classId);

            if ($sectionId !== null) {
                $studentQuery->where('section_id', $sectionId);
            }

            $students = $studentQuery->orderBy('name')->get();
        }

        if ($students->isEmpty()) {
            $message = $sectionId !== null
                ? 'No students found for the selected class and section.'
                : 'No students found for the selected class.';

            return back()
                ->withInput()
                ->withErrors([
                    'class_id' => $message,
                ]);
        }

        $classFees = ClassFee::with('feeType')
            ->where('class_id', $classId)
            ->where('status', 'Active')
            ->get();

        if ($classFees->isEmpty()) {
            return back()
                ->withInput()
                ->withErrors([
                    'class_id' => 'No active fees are set for this class.',
                ]);
        }

        $year = (int) date('Y', strtotime($request->issue_date));
        $monthNumber = app(StudentMonthlyFeeCalculator::class)->monthToNumber($request->month);
        $processedStudentIds = [];
        $createdFeeCount = 0;

        DB::transaction(function () use (
            $students,
            $classFees,
            $request,
            $year,
            $monthNumber,
            &$processedStudentIds,
            &$createdFeeCount
        ) {
            $calculator = app(StudentMonthlyFeeCalculator::class);

            foreach ($students as $student) {
                $studentHadNewFee = false;

                foreach ($classFees as $classFee) {
                    $isAdjustmentFee = $classFee->feeType
                        && $classFee->feeType->is_adjustment;

                    if ($isAdjustmentFee) {
                        $adjustmentAlreadyProcessed = FeeProcess::where('student_id', $student->id)
                            ->where('fee_type_id', $classFee->fee_type_id)
                            ->whereHas('feeType', function ($query) {
                                $query->where('is_adjustment', true);
                            })
                            ->exists();

                        if ($adjustmentAlreadyProcessed) {
                            continue;
                        }
                    }

                    $alreadyExists = FeeProcess::where('student_id', $student->id)
                        ->where('fee_type_id', $classFee->fee_type_id)
                        ->where('month', $request->month)
                        ->where('year', $year)
                        ->where('session', $request->session)
                        ->exists();

                    if ($alreadyExists) {
                        continue;
                    }

                    FeeProcess::create([
                        'student_id' => $student->id,
                        'class_id' => $student->class_id,
                        'section_id' => $student->section_id,
                        'fee_type_id' => $classFee->fee_type_id,
                        'amount' => $classFee->amount,
                        'month' => $request->month,
                        'year' => $year,
                        'status' => 'Processed',
                        'session' => $request->session,
                        'issue_date' => $request->issue_date,
                        'due_date' => $request->due_date,
                    ]);

                    $createdFeeCount++;
                    $studentHadNewFee = true;
                }

                // Always sync fee_collections for this student/month (incl. compulsory Monthly Fees)
                $synced = $calculator->syncStudentMonthFees(
                    $student,
                    $monthNumber,
                    $year,
                    $request->issue_date
                );

                if ($synced > 0) {
                    $studentHadNewFee = true;
                }

                // Ensure FeeProcess also records Monthly Fees when catalog has it
                // and ClassFee list did not already create the same fee type for this month.
                $monthlyFee = $calculator->resolveMonthlyFeeCatalog($student);
                if ($monthlyFee) {
                    $classAlreadyHasMonthlyType = $classFees->contains(
                        fn ($classFee) => (int) $classFee->fee_type_id === (int) $monthlyFee->fee_type_id
                    );

                    if (! $classAlreadyHasMonthlyType) {
                        $monthlyProcessExists = FeeProcess::where('student_id', $student->id)
                            ->where('fee_type_id', $monthlyFee->fee_type_id)
                            ->where('month', $request->month)
                            ->where('year', $year)
                            ->where('session', $request->session)
                            ->exists();

                        if (! $monthlyProcessExists) {
                            FeeProcess::create([
                                'student_id' => $student->id,
                                'class_id' => $student->class_id,
                                'section_id' => $student->section_id,
                                'fee_type_id' => $monthlyFee->fee_type_id,
                                'amount' => $monthlyFee->amount,
                                'month' => $request->month,
                                'year' => $year,
                                'status' => 'Processed',
                                'session' => $request->session,
                                'issue_date' => $request->issue_date,
                                'due_date' => $request->due_date,
                            ]);
                            $createdFeeCount++;
                            $studentHadNewFee = true;
                        }
                    }
                }

                if ($studentHadNewFee) {
                    $processedStudentIds[] = $student->id;
                }
            }
        });

        $studentCount = count($processedStudentIds);

        if ($studentCount === 0) {
            return redirect()
                ->route('fee-process.list')
                ->with(
                    'success',
                    'No new fees were created. Fees for the selected session/month may already exist for these students.'
                );
        }

        return redirect()
            ->route('fee-process.list')
            ->with(
                'success',
                'Fee processed successfully for '.$studentCount.' '.($studentCount === 1 ? 'student' : 'students').'.'
            );
    }

    public function processedFees()
    {
        $fees = FeeProcess::with([
            'student',
            'studentClass',
            'feeType',
        ])
            ->selectRaw('
                MIN(id) as id,
                student_id,
                class_id,
                section_id,
                month,
                year,
                session,
                issue_date,
                due_date,
                status
            ')
            ->groupBy(
                'student_id',
                'class_id',
                'section_id',
                'month',
                'year',
                'session',
                'issue_date',
                'due_date',
                'status'
            )
            ->latest('id')
            ->get();

        return view('fee-process.list', compact('fees'));
    }

    public function destroy($id)
    {
        $fee = FeeProcess::findOrFail($id);

        FeeProcess::where('student_id', $fee->student_id)
            ->where('class_id', $fee->class_id)
            ->where('section_id', $fee->section_id)
            ->where('month', $fee->month)
            ->where('year', $fee->year)
            ->where('session', $fee->session)
            ->where('issue_date', $fee->issue_date)
            ->where('due_date', $fee->due_date)
            ->where('status', $fee->status)
            ->delete();

        return redirect()
            ->route('fee-process.list')
            ->with('success', 'Fee process deleted successfully.');
    }

    public function show($id)
    {
        $selectedFee = FeeProcess::with([
            'student',
            'studentClass',
            'feeType',
        ])->findOrFail($id);

        $fees = FeeProcess::with([
            'student',
            'studentClass',
            'feeType',
        ])
            ->where('student_id', $selectedFee->student_id)
            ->where('month', $selectedFee->month)
            ->where('year', $selectedFee->year)
            ->where('session', $selectedFee->session)
            ->orderBy('fee_type_id')
            ->get();

        return view('fee-process.show', compact(
            'fees',
            'selectedFee'
        ));
    }

    public function processLines()
    {
        $fees = FeeProcess::with([
            'student',
            'studentClass',
            'feeType',
        ])
            ->latest()
            ->get();

        return view('fee-process.process-lines', compact('fees'));
    }
}
