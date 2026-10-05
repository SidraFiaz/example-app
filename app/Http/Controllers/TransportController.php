<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $transports = Transport::with([
            'student.studentClass',
        ])
            ->latest()
            ->get();

        $students = Student::with('studentClass')
            ->orderBy('name')
            ->get();

        return view('transport.index', compact('transports', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'nullable|date',
            'transport_fee' => 'nullable|numeric|min:0',
            'vehicle_no' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:255',
            'driver_name' => 'nullable|string|max:255',
            'stop_name' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'remarks' => 'nullable|string',
        ]);

        Transport::create($validated);

        return redirect()
            ->route('transport.index')
            ->with('success', 'Transport saved successfully.');
    }

    public function edit(Transport $transport)
    {
        $students = Student::with('studentClass')
            ->orderBy('name')
            ->get();

        return view('transport.edit', compact('transport', 'students'));
    }

    public function update(Request $request, Transport $transport)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'date' => 'nullable|date',
            'transport_fee' => 'nullable|numeric|min:0',
            'vehicle_no' => 'nullable|string|max:255',
            'registration_no' => 'nullable|string|max:255',
            'driver_name' => 'nullable|string|max:255',
            'stop_name' => 'nullable|string|max:255',
            'status' => 'required|in:Active,Inactive',
            'remarks' => 'nullable|string',
        ]);

        $transport->update($validated);

        return redirect()
            ->route('transport.index')
            ->with('success', 'Transport updated successfully.');
    }

    public function destroy(Transport $transport)
    {
        $transport->delete();

        return redirect()
            ->route('transport.index')
            ->with('success', 'Transport deleted successfully.');
    }
}
