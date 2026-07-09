<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    protected $table = 'classes';

    protected $fillable = [
        'class_name',
    ];

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'class_id');
    }
}