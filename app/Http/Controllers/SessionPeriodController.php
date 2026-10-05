<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\SessionPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SessionPeriodController extends Controller
{
    public function index(Session $session)
    {
        $periods = $session->sessionPeriods()
            ->orderBy('period_month')
            ->get();

        return view('session-periods.index', compact('session', 'periods'));
    }

    public function generate(Session $session)
    {
        if ($session->sessionPeriods()->exists()) {
            return redirect()
                ->route('session-periods.index', $session->id)
                ->with('error', 'Period has already been generated.');
        }

        $start = Carbon::parse($session->session_from)->startOfMonth();
        $end = Carbon::parse($session->session_to)->startOfMonth();

        while ($start->lte($end)) {

            SessionPeriod::create([
                'session_id'   => $session->id,
                'period_month' => $start->copy(),
                'is_active'    => false,
            ]);

            $start->addMonth();
        }

        return redirect()
            ->route('session-periods.index', $session->id)
            ->with('success', 'Session periods generated successfully.');
    }

    public function toggle(SessionPeriod $sessionPeriod)
    {
        if ($sessionPeriod->is_active) {
            return back()
                ->with('success', 'Period status updated successfully.');
        }

        DB::transaction(function () use ($sessionPeriod) {
            SessionPeriod::where('session_id', $sessionPeriod->session_id)
                ->where('is_active', true)
                ->where('id', '!=', $sessionPeriod->id)
                ->update(['is_active' => false]);

            $sessionPeriod->update([
                'is_active' => true,
            ]);
        });

        return back()
            ->with('success', 'Period status updated successfully.');
    }
}