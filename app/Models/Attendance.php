<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    protected $fillable = [
        'student_id',
        'class_id',
        'section_id',
        'session_id',
        'attendance_date',
        'status',
    ];


    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class,'class_id');
    }


    public function section()
    {
        return $this->belongsTo(Section::class);
    }


    public function session()
    {
        return $this->belongsTo(Session::class);
    }

}