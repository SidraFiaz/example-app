<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeProcess extends Model
{
   protected $fillable = [
    'student_id',
    'class_id',
    'section_id',
    'fee_type_id',
    'amount',
    'month',
    'year',
    'session',
    'issue_date',
    'due_date',
    'status',
];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}