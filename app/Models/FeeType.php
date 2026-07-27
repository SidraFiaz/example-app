<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    protected $fillable = [
        'fee_name',
    ];

    public function classFees()
{
    return $this->hasMany(ClassFee::class);
}

}