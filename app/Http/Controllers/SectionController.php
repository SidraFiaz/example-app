<?php

namespace App\Http\Controllers;
use App\Models\Section;

use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index($class_id)
{
    // dd($class_id);
    return view('sections.index', compact('class_id'));
}

public function create($class_id)
{
    return view('sections.create', compact('class_id'));
}

    public function store(Request $request, $class_id)
{
    Section::create([
        'class_id' => $class_id,
        'section_name' => $request->section_name,
    ]);

    return redirect()->route('sections.index', $class_id);
}
}