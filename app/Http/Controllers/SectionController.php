<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;

class SectionController extends Controller
{
    // Show all sections of a class
    public function index($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();

        return view('sections.index', compact('class_id', 'sections'));
    }

    // Show create form
    public function create($class_id)
    {
        return view('sections.create', compact('class_id'));
    }

    // Store new section
    public function store(Request $request, $class_id)
    {
        $request->validate([
            'section_name' => 'required|max:255',
        ]);

        Section::create([
            'class_id' => $class_id,
            'section_name' => $request->section_name,
        ]);

        return redirect()->route('sections.index', $class_id)
            ->with('success', 'Section added successfully.');
    }

    // Delete section
    public function destroy($class_id, $id)
    {
        $section = Section::findOrFail($id);

        $section->delete();

        return redirect()->route('sections.index', $class_id)
            ->with('success', 'Section deleted successfully.');
    }

    // Return sections according to selected class (AJAX)
    public function getSections($class_id)
    {
        $sections = Section::where('class_id', $class_id)->get();

        return response()->json($sections);
    }
}