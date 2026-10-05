<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    protected $fillable = [
    'group_name',
    'class_id',
];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}