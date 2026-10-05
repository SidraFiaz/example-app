<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdvanceFee extends Model
{
    protected $fillable = [
        'student_id',
        'advance_month',
        'payment_date',
        'amount',
        'adjusted_amount',
    ];

    protected $casts = [
        'advance_month' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'adjusted_amount' => 'decimal:2',
    ];

    /*
    |--------------------------------------------------------------------------
    | Student
    |--------------------------------------------------------------------------
    */

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Remaining Amount
    |--------------------------------------------------------------------------
    */

    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->adjusted_amount;
    }
}