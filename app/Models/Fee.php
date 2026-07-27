<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fee extends Model
{
    protected $fillable = [
        'class_id',
        'fee_type_id',
        'amount',
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }
}