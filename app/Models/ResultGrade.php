<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultGrade extends Model
{
    protected $fillable = [
        'exam_id',
        'class_group',
        'grade',
        'starting_percentage',
        'ending_percentage',
        'date',
        'term',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}