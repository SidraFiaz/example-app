<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = Session::latest()->get();

        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'session_from' => 'required|date',
            'session_to' => 'nullable|date|after_or_equal:session_from',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->boolean('is_active')) {
            Session::where('is_active', true)
                ->update(['is_active' => false]);
        }

        Session::create([
            'name' => $validated['name'],
            'session_from' => $validated['session_from'],
            'session_to' => $validated['session_to'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('sessions.index')
            ->with('success', 'Session created successfully.');
    }

    public function edit(Session $session)
    {
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, Session $session)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'session_from' => 'required|date',
            'session_to' => 'nullable|date|after_or_equal:session_from',
            'is_active' => 'nullable|boolean',
        ]);

        if ($request->boolean('is_active')) {
            Session::where('id', '!=', $session->id)
                ->where('is_active', true)
                ->update(['is_active' => false]);
        }

        $session->update([
            'name' => $validated['name'],
            'session_from' => $validated['session_from'],
            'session_to' => $validated['session_to'] ?? null,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('sessions.index')
            ->with('success', 'Session updated successfully.');
    }

    public function destroy(Session $session)
    {
        $session->delete();

        return redirect()
            ->route('sessions.index')
            ->with('success', 'Session deleted successfully.');
    }
}