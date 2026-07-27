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

    public function fee()
{
    return $this->hasOne(Fee::class, 'class_id');
}
public function fees()
{
    return $this->hasMany(Fee::class, 'class_id');
}

public function classFees()
{
    return $this->hasMany(ClassFee::class, 'class_id');
}


}