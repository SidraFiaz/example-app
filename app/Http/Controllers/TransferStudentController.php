<?php

namespace App\Http\Controllers;

use App\Models\StudentClass;
use App\Models\Section;
use App\Models\Branch;
use App\Models\Admission;
use Illuminate\Http\Request;
use App\Models\TransferStudent;
use Carbon\Carbon;

class TransferStudentController extends Controller
{
   public function create($id)
{
    $admission = Admission::with([
        'studentClass',
        'section'
    ])->findOrFail($id);

    $branches = Branch::where('is_active',1)
        ->orderBy('name')
        ->get();

    $classes = StudentClass::orderBy('class_name')
        ->get();

    $sections = Section::orderBy('section_name')
        ->get();

    return view('transfer-student.create', compact(
        'admission',
        'branches',
        'classes',
        'sections'
    ));
}


   public function store(Request $request, $id)
{
    $request->validate([

        'branch_id' => 'required|exists:branches,id',

        'class_id' => 'required|exists:classes,id',

        'section_id' => 'required|exists:sections,id',

    ]);


    $admission = Admission::findOrFail($id);


    TransferStudent::create([

        'admission_id' => $admission->id,


        // Old class & section
        'old_class_id' => $admission->class_id,

        'old_section_id' => $admission->section_id,


        // New details
        'branch_id' => $request->branch_id,

        'new_class_id' => $request->class_id,

        'new_section_id' => $request->section_id,


        'transfer_date' => Carbon::now(),

        'reason' => $request->reason,

    ]);


    // student ka class aur section update

    $admission->update([

        'class_id' => $request->class_id,

        'section_id' => $request->section_id,

    ]);


    return redirect()

        ->route('admission.index')

        ->with('success','Student transferred successfully!');
}
}