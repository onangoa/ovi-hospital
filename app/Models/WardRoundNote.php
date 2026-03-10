<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WardRoundNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'mrn',
        'bed_number',
        'attending_clinician',
        'main_complaints',
        'examination_findings',
        'respiratory_status',
        'respiratory_comments',
        'cardiovascular_status',
        'cardiovascular_comments',
        'neurological_status',
        'neurological_comments',
        'gastrointestinal_status',
        'gastrointestinal_comments',
        'skin_status',
        'skin_comments',
        'medications_changes',
        'procedures_interventions',
        'pending_tests',
        'condition',
        'next_steps',
        'clinician_name',
        'signature',
        'vital_signs',
    ];

    protected $casts = [
        'date' => 'date',
        'vital_signs' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function attendingClinician()
    {
        return $this->belongsTo(User::class, 'attending_clinician');
    }
}
