<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeCollection extends Model
{
    protected $fillable = [
        'student_id',
        'fee_type_id',
        'fee_id',
        'amount',
        'amount_paid',
        'payment_date',
        'month',
        'year',
        'status',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'float',
        'amount_paid' => 'float',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class, 'fee_id');
    }
}