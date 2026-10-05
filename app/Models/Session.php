<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'academic_sessions';

    protected $fillable = [
        'session_from',
        'session_to',
        'name',
        'is_active',
    ];

    protected $casts = [
        'session_from' => 'date',
        'session_to'   => 'date',
        'is_active'    => 'boolean',
    ];

    public function sessionPeriods()
    {
        return $this->hasMany(SessionPeriod::class);
    }

    /**
     * Calendar months covered by this session, in chronological order (each month once).
     *
     * @return array<int, array{value: int, label: string}>
     */
    public function monthsInRange(): array
    {
        if (!$this->session_from || !$this->session_to) {
            return [];
        }

        $cursor = $this->session_from->copy()->startOfMonth();
        $end = $this->session_to->copy()->startOfMonth();

        if ($cursor->gt($end)) {
            return [];
        }

        $months = [];
        $seen = [];

        while ($cursor->lte($end)) {
            $value = (int) $cursor->month;

            if (!isset($seen[$value])) {
                $seen[$value] = true;
                $months[] = [
                    'value' => $value,
                    'label' => $cursor->format('F'),
                ];
            }

            $cursor->addMonthNoOverflow();
        }

        return $months;
    }
}