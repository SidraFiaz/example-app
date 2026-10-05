<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Admission;

class StudentAttachment extends Model
{
    use HasFactory;

    protected $table = 'student_attachments';

    protected $fillable = [
        'admission_id',
        'attachment_name',
        'remarks',
        'file_path',
        'certificate_given',
    ];

    protected $casts = [
        'certificate_given' => 'boolean',
    ];

    public function admission()
    {
        return $this->belongsTo(Admission::class);
    }
}