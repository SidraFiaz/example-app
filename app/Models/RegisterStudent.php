<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegisterStudent extends Model
{
    protected $table = 'register_students';

    protected $fillable = [
        'class_id',
        'student_id',
        'admission_no',
        'admission_no_2',
        'form_no',
        'registration_no',
        'roll_no',
        'obtain_marks',
        'admission_date',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'obtain_marks' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}
