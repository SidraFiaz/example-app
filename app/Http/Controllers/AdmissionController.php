<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\StudentClass;
use App\Models\Section;
use Illuminate\Http\Request;

class AdmissionController extends Controller
{
    /**
     * Display admissions.
     */
    public function index()
    {
        $admissions = Admission::with([
            'studentClass',
            'section'
        ])->latest()->get();

        $classes = StudentClass::orderBy('class_name')->get();

        $sections = Section::orderBy('section_name')->get();

        return view('admission.index', compact(
            'admissions',
            'classes',
            'sections'
        ));
    }

    /**
     * Display deleted admissions.
     */
    public function deleted()
    {
        $admissions = Admission::onlyTrashed()
            ->with([
                'studentClass',
                'section'
            ])
            ->latest('deleted_at')
            ->get();

        return view('admission.deleted', compact('admissions'));
    }

    /**
     * Show admission form.
     */
    public function create()
    {
        $classes = StudentClass::orderBy('class_name')->get();

        $sections = Section::orderBy('section_name')->get();

        return view('admission.create', compact(
            'classes',
            'sections'
        ));
    }

    /**
     * Store admission.
     */
    public function store(Request $request)
    {
        $request->validate([
            'student_name'        => 'required|string|max:255',
            'father_name'         => 'required|string|max:255',
            'family_no'           => 'nullable|string|max:255',

            'b_form_no'           => 'nullable|string|max:255',
            'date_of_birth'       => 'nullable|date',

            'father_email'        => 'nullable|email|max:255',
            'father_cnic'         => 'nullable|string|max:30',

            'mother_name'         => 'nullable|string|max:255',
            'mother_email'        => 'nullable|email|max:255',
            'mother_mobile'       => 'nullable|string|max:30',
            'mother_cnic'         => 'nullable|string|max:30',

            'permanent_address'   => 'nullable|string',
            'identification_mark' => 'nullable|string|max:255',

            'blood_group'         => 'nullable|string|max:20',
            'gender'              => 'nullable|string|max:30',
            'student_city'        => 'nullable|string|max:255',
            'student_country'     => 'nullable|string|max:255',

            'class_id'            => 'required|exists:classes,id',
            'section_id'          => 'required|exists:sections,id',

            'status'              => 'required|in:Active,Passed out,Rusticate,Expelled,Transfer,Double',
            'status_date'         => 'nullable|date',

            'admission_date'      => 'required|date',
            'father_contact'      => 'nullable|string|max:30',
        ]);

        Admission::create([
            'student_name'        => $request->student_name,
            'father_name'         => $request->father_name,
            'family_no'           => $request->family_no,

            'b_form_no'           => $request->b_form_no,
            'date_of_birth'       => $request->date_of_birth,

            'father_email'        => $request->father_email,
            'father_cnic'         => $request->father_cnic,

            'mother_name'         => $request->mother_name,
            'mother_email'        => $request->mother_email,
            'mother_mobile'       => $request->mother_mobile,
            'mother_cnic'         => $request->mother_cnic,

            'permanent_address'   => $request->permanent_address,
            'identification_mark' => $request->identification_mark,

            'blood_group'         => $request->blood_group,
            'gender'              => $request->gender,
            'student_city'        => $request->student_city,
            'student_country'     => $request->student_country,

            'class_id'            => $request->class_id,
            'section_id'          => $request->section_id,

            'status'              => $request->status,
            'status_date'         => $request->status_date,

            'admission_date'      => $request->admission_date,
            'father_contact'      => $request->father_contact,
        ]);

        return redirect()
            ->route('admission.index')
            ->with('success', 'Admission saved successfully!');
    }

    public function leavingCertificate($id)
{
    $admission = Admission::with([
        'studentClass',
        'section'
    ])->findOrFail($id);

    return view('admission.leaving-certificate', compact('admission'));
}

    /**
     * Show admission.
     */
    public function show(Admission $admission)
    {
        $admission->load([
            'studentClass',
            'section'
        ]);

        // IMPORTANT:
        // Student View ke Class aur Section dropdown ke liye
        // ye dono variables view ko dene zaroori hain.

        $classes = StudentClass::orderBy('class_name')->get();

        $sections = Section::orderBy('section_name')->get();

        return view('admission.show', compact(
            'admission',
            'classes',
            'sections'
        ));
    }

    /**
     * Show edit form.
     */
    public function edit(Admission $admission)
    {
        $classes = StudentClass::orderBy('class_name')->get();

        $sections = Section::orderBy('section_name')->get();

        return view('admission.edit', compact(
            'admission',
            'classes',
            'sections'
        ));
    }

    /**
     * Normal update.
     */
    public function update(Request $request, Admission $admission)
    {
        $request->validate([
            'student_name'        => 'required|string|max:255',
            'father_name'         => 'required|string|max:255',
            'family_no'           => 'nullable|string|max:255',

            'b_form_no'           => 'nullable|string|max:255',
            'date_of_birth'       => 'nullable|date',

            'father_email'        => 'nullable|email|max:255',
            'father_cnic'         => 'nullable|string|max:30',

            'mother_name'         => 'nullable|string|max:255',
            'mother_email'        => 'nullable|email|max:255',
            'mother_mobile'       => 'nullable|string|max:30',
            'mother_cnic'         => 'nullable|string|max:30',

            'permanent_address'   => 'nullable|string',
            'identification_mark' => 'nullable|string|max:255',

            'blood_group'         => 'nullable|string|max:20',
            'gender'              => 'nullable|string|max:30',
            'student_city'        => 'nullable|string|max:255',
            'student_country'     => 'nullable|string|max:255',

            'class_id'            => 'required|exists:classes,id',
            'section_id'          => 'required|exists:sections,id',

            'status'              => 'required|in:Active,Passed out,Rusticate,Expelled,Transfer,Double',
            'status_date'         => 'nullable|date',

            'admission_date'      => 'required|date',
            'father_contact'      => 'nullable|string|max:30',
        ]);

        $admission->update([
            'student_name'        => $request->student_name,
            'father_name'         => $request->father_name,
            'family_no'           => $request->family_no,

            'b_form_no'           => $request->b_form_no,
            'date_of_birth'       => $request->date_of_birth,

            'father_email'        => $request->father_email,
            'father_cnic'         => $request->father_cnic,

            'mother_name'         => $request->mother_name,
            'mother_email'        => $request->mother_email,
            'mother_mobile'       => $request->mother_mobile,
            'mother_cnic'         => $request->mother_cnic,

            'permanent_address'   => $request->permanent_address,
            'identification_mark' => $request->identification_mark,

            'blood_group'         => $request->blood_group,
            'gender'              => $request->gender,
            'student_city'        => $request->student_city,
            'student_country'     => $request->student_country,

            'class_id'            => $request->class_id,
            'section_id'          => $request->section_id,

            'status'              => $request->status,
            'status_date'         => $request->status_date,

            'admission_date'      => $request->admission_date,
            'father_contact'      => $request->father_contact,
        ]);

        return redirect()
            ->route('admission.index')
            ->with('success', 'Admission updated successfully!');
    }

    /**
     * Update Basic Info from Student View.
     */
    public function updateBasicInfo(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'student_name'        => 'required|string|max:255',
            'father_name'         => 'required|string|max:255',
            'family_no'           => 'nullable|string|max:255',

            'b_form_no'           => 'nullable|string|max:255',
            'date_of_birth'       => 'nullable|date',

            'father_email'        => 'nullable|email|max:255',
            'father_cnic'         => 'nullable|string|max:30',

            'mother_name'         => 'nullable|string|max:255',
            'mother_email'        => 'nullable|email|max:255',
            'mother_mobile'       => 'nullable|string|max:30',
            'mother_cnic'         => 'nullable|string|max:30',

            'permanent_address'   => 'nullable|string',
            'identification_mark' => 'nullable|string|max:255',

            'blood_group'         => 'nullable|string|max:20',
            'gender'              => 'nullable|string|max:30',
            'student_city'        => 'nullable|string|max:255',
            'student_country'     => 'nullable|string|max:255',

            'status'              => 'required|in:Active,Passed out,Rusticate,Expelled,Transfer,Double',
            'status_date'         => 'nullable|date',

            'admission_date'      => 'required|date',
            'father_contact'      => 'nullable|string|max:30',
        ]);

        $admission->update($validated);

        return redirect()
            ->route('admission.show', $admission)
            ->with('success', 'Basic information updated successfully!');
    }

    /**
     * Update Class & Section from Student View.
     */
    public function updateClassSection(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'class_id'   => 'required|exists:classes,id',
            'section_id' => 'required|exists:sections,id',
        ]);

        $admission->update($validated);

        return redirect()
            ->route('admission.show', $admission)
            ->with('success', 'Class & Section updated successfully!');
    }

    /**
     * Export admissions.
     */
    public function export()
    {
        $admissions = Admission::with([
            'studentClass',
            'section'
        ])->latest()->get();

        $filename = 'student-data-' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        return response()->stream(function () use ($admissions) {

            $handle = fopen('php://output', 'w');

            fputcsv($handle, [
                'ID',
                'Student Name',
                'Father Name',
                'Family No',
                'B-form No',
                'Date of Birth',
                'Father Email',
                'Father CNIC',
                'Mother Name',
                'Mother Email',
                'Mother Mobile',
                'Mother CNIC',
                'Permanent Address',
                'Identification Mark',
                'Blood Group',
                'Gender',
                'Student City',
                'Student Country',
                'Class',
                'Section',
                'Status',
                'Status Date',
                'Admission Date',
                'Father Contact',
            ]);

            foreach ($admissions as $admission) {

                fputcsv($handle, [
                    $admission->id,
                    $admission->student_name,
                    $admission->father_name,
                    $admission->family_no ?? '',
                    $admission->b_form_no ?? '',
                    $admission->date_of_birth?->format('d-m-Y') ?? '',
                    $admission->father_email ?? '',
                    $admission->father_cnic ?? '',
                    $admission->mother_name ?? '',
                    $admission->mother_email ?? '',
                    $admission->mother_mobile ?? '',
                    $admission->mother_cnic ?? '',
                    $admission->permanent_address ?? '',
                    $admission->identification_mark ?? '',
                    $admission->blood_group ?? '',
                    $admission->gender ?? '',
                    $admission->student_city ?? '',
                    $admission->student_country ?? '',
                    $admission->studentClass->class_name ?? '',
                    $admission->section->section_name ?? '',
                    $admission->status,
                    $admission->status_date?->format('d-m-Y') ?? '',
                    $admission->admission_date?->format('d-m-Y') ?? '',
                    $admission->father_contact ?? '',
                ]);
            }

            fclose($handle);

        }, 200, $headers);
    }

    /**
     * Polio Report.
     */
    public function polioReport($class_id)
    {
        $admissions = Admission::with([
            'studentClass',
            'section'
        ])
        ->where('class_id', $class_id)
        ->where('status', 'Active')
        ->get();

        $class = StudentClass::findOrFail($class_id);

        return view('admission.polio-report', compact(
            'admissions',
            'class'
        ));
    }

    /**
     * Restore deleted admission.
     */
    public function restore($id)
    {
        $admission = Admission::onlyTrashed()->findOrFail($id);

        $admission->restore();

        return redirect()
            ->route('admission.deleted')
            ->with('success', 'Student restored successfully!');
    }

    /**
     * Delete admission.
     */
    public function destroy(Admission $admission)
    {
        $admission->delete();

        return redirect()
            ->route('admission.index')
            ->with('success', 'Admission deleted successfully!');
    }
}