<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFee extends Model
{
    protected $fillable = [
    'class_id',
    'fee_type_id',
    'fee_type',
    'amount',
    'status',
];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
}