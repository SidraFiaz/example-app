<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeCollection extends Model
{
   protected $fillable = [
    'student_id',
    'fee_type_id',
    'amount',
    'payment_date',
    'month',
    'year',
    'status',
    'remarks',
];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}