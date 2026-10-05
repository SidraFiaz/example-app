<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DateSheet extends Model
{
    protected $fillable = [
        'session_id',
        'exam_id',
        'class_id',
    ];

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}
