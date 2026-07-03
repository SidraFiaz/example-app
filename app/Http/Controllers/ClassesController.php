<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudentClass;

class ClassesController extends Controller
{
    public function index()
    {
        // dd('sdf');
        $classes = StudentClass::all();

        return view('classes.index', compact('classes'));
    }

    public function create()
    {
        return view('classes.create-class');
    }

    public function store(Request $request)
    {
        StudentClass::create([
            'class_name' => $request->class_name,
        ]);

        return redirect()->route('classes');
    }

    public function edit($id)
{
    $class = StudentClass::findOrFail($id);

    return view('classes.edit', compact('class'));
}

public function update(Request $request, $id)
{
    $class = StudentClass::findOrFail($id);

    $class->update([
        'class_name' => $request->class_name,
    ]);

    return redirect()->route('classes');
}

public function destroy($id)
{
    $class = StudentClass::findOrFail($id);

    $class->delete();

    return redirect()->route('classes')
                     ->with('success', 'Class deleted successfully.');
}

}