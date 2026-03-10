<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadiologyRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'provider_id',
        'examination_type',
        'examination_details',
        'relevant_clinical_information',
        'reason_for_investigation',
    ];




    protected $casts = [
        'examination_type' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
