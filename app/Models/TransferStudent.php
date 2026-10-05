<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransferStudent extends Model
{
    protected $fillable = [

        'admission_id',

        'old_class_id',
        'old_section_id',

        'branch_id',

        'new_class_id',
        'new_section_id',

        'transfer_date',
        'reason',

    ];


    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }


    public function oldClass()
    {
        return $this->belongsTo(StudentClass::class, 'old_class_id');
    }


    public function newClass()
    {
        return $this->belongsTo(StudentClass::class, 'new_class_id');
    }


    public function oldSection()
    {
        return $this->belongsTo(Section::class, 'old_section_id');
    }


    public function newSection()
    {
        return $this->belongsTo(Section::class, 'new_section_id');
    }
}