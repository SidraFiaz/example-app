<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionPeriod extends Model
{
    protected $fillable = [
        'session_id',
        'period_month',
        'is_active',
    ];

    protected $casts = [
        'period_month' => 'date',
        'is_active' => 'boolean',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class);
    }
}