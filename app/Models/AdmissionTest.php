<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdmissionTest extends Model
{
    protected $fillable = [
        'class_id',
        'session_id',
        'file_path',
        'file_name',
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }
}
