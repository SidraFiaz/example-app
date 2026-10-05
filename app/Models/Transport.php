<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = [
        'student_id',
        'date',
        'transport_fee',
        'vehicle_no',
        'registration_no',
        'driver_name',
        'stop_name',
        'status',
        'remarks',
    ];

    protected $casts = [
        'date' => 'date',
        'transport_fee' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
