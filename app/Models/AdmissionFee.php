<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdmissionFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'admission_id',
        'type',
        'amount',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}