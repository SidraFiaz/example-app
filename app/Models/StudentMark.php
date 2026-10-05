<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentMark extends Model
{
    protected $fillable = [
        'exam_id',
        'student_id',
        'class_id',
        'section_id',
        'subject_id',
        'session_id',
        'total_marks',
        'obtained_marks',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
        'total_marks' => 'float',
        'obtained_marks' => 'float',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
}
