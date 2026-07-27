<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'age',
        'email',
        'gender',
        'class_id',
        'section_id',
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
public function section()
{
    return $this->belongsTo(Section::class, 'section_id');
}

public function feeCollections()
{
    return $this->hasMany(FeeCollection::class);
}


}