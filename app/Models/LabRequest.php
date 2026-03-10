<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'age',
        'sex',
        'resident',
        'specimen',
        'blood_bank',
        'histology',
        'serology',
        'haematology',
        'bacteriology',
        'parasitology',
        'biochemistry',
        'other_destination',
        'investigation_requested',
        'differential_diagnosis',
        'clinician_name',
        'clinician_id',
        'request_date',
        'vital_signs',
    ];

    protected $casts = [
        'collection_datetime' => 'datetime',
        'request_date' => 'date',
        'blood_bank' => 'boolean',
        'histology' => 'boolean',
        'serology' => 'boolean',
        'haematology' => 'boolean',
        'bacteriology' => 'boolean',
        'parasitology' => 'boolean',
        'biochemistry' => 'boolean',
        'vital_signs' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function clinician()
    {
        return $this->belongsTo(User::class, 'clinician_id');
    }
}
