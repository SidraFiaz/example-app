<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentMeeting extends Model
{
    protected $fillable = [
        'student_id',
        'meeting_date',
        'purpose',
        'meeting_attend',
    ];

    protected $casts = [
        'meeting_date' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
