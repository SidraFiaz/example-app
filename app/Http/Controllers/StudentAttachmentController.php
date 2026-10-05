<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Models\StudentAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentAttachmentController extends Controller
{
    public function create(Admission $admission)
    {
        $attachments = $admission->attachments()
            ->latest()
            ->get();

        return view('admission.attachments', compact(
            'admission',
            'attachments'
        ));
    }


    public function store(Request $request, Admission $admission)
    {
        $validated = $request->validate([
            'attachment_name' => 'required|string|max:255',
            'remarks' => 'nullable|string',
            'file' => 'required|file|max:10240',
            'certificate_given' => 'nullable|boolean',
        ]);


        $path = $request->file('file')->store(
            'student-attachments',
            'public'
        );


        $admission->attachments()->create([
            'attachment_name' => $validated['attachment_name'],
            'remarks' => $validated['remarks'] ?? null,
            'file_path' => $path,
            'certificate_given' => $request->has('certificate_given'),
        ]);


        return back()->with(
            'success',
            'Attachment added successfully.'
        );
    }


    public function download(StudentAttachment $studentAttachment)
    {
        if (!Storage::disk('public')->exists(
            $studentAttachment->file_path
        )) {
            abort(404);
        }

        return Storage::disk('public')->download(
            $studentAttachment->file_path,
            $studentAttachment->attachment_name
        );
    }


    public function destroy(StudentAttachment $studentAttachment)
    {
        if (
            $studentAttachment->file_path &&
            Storage::disk('public')->exists(
                $studentAttachment->file_path
            )
        ) {
            Storage::disk('public')->delete(
                $studentAttachment->file_path
            );
        }


        $studentAttachment->delete();


        return back()->with(
            'success',
            'Attachment deleted successfully.'
        );
    }
}