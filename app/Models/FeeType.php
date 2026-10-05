<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    protected $fillable = [
        'fee_name',
        'is_adjustment',
    ];

    protected $casts = [
        'is_adjustment' => 'boolean',
    ];

    public function classFees()
    {
        return $this->hasMany(ClassFee::class);
    }

    public function feeCollections()
    {
        return $this->hasMany(FeeCollection::class);
    }
}