<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\StudentAttachment;
use App\Models\AdmissionFee;

class Admission extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'student_name',
        'father_name',
        'family_no',

        'b_form_no',
        'date_of_birth',

        'father_email',
        'father_cnic',

        'mother_name',
        'mother_email',
        'mother_mobile',
        'mother_cnic',

        'permanent_address',
        'identification_mark',

        'blood_group',
        'gender',
        'student_city',
        'student_country',

        'class_id',
        'section_id',

        'status',
        'status_date',

        'admission_date',
        'father_contact',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'date_of_birth' => 'date',
        'status_date' => 'date',
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }

    public function attachments()
{
    return $this->hasMany(StudentAttachment::class);
}

public function admissionFees()
{
    return $this->hasMany(AdmissionFee::class);
}
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }
}