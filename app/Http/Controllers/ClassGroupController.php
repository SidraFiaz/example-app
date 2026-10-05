<?php

namespace App\Http\Controllers;

use App\Models\ClassGroup;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class ClassGroupController extends Controller
{
    public function index()
    {
        $classGroups = ClassGroup::with('studentClass')
            ->latest()
            ->get();

        $classes = StudentClass::orderBy('class_name')->get();

        $groups = [
            'Pre-Primary',
            'Primary',
            'Middle',
            'Secondary',
        ];

        return view('class-groups.index', compact(
            'classGroups',
            'classes',
            'groups'
        ));
    }

   public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'class_id' => 'required|exists:classes,id',
    ]);

    ClassGroup::create([
        'group_name' => $request->name,
        'class_id' => $request->class_id,
    ]);

    return redirect()
        ->route('class-groups.index')
        ->with('success', 'Class Group Created Successfully');
}
public function destroy(ClassGroup $classGroup)
{
    $classGroup->delete();

    return redirect()
        ->route('class-groups.index')
        ->with('success', 'Class Group deleted successfully.');
}
}