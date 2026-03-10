<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'referring_doctor_id',
        'reason_for_referral',
        'chief_complaint',
        'patient_brief_history',
        'vital_signs',
        'lab_investigation_done',
        'treatment_done',
    ];



    protected $casts = [
        'vital_signs' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function referringDoctor()
    {
        return $this->belongsTo(User::class, 'referring_doctor_id');
    }

    public function setReferringDoctorNameAttribute($value)
    {
        $this->attributes['referring_doctor_id'] = $value;
    }
}
