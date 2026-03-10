<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarePlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'provider_id',
        'date',
        'medications',
        'dietary_needs',
        'activity_restrictions',
        'wound_care',
        'admission_decision',
        'tests_needed',
        'tests_comments',
        'provider_signature',
        'signature_date',
    ];

    protected $casts = [
        'medications' => 'array',
        'date' => 'date',
    ];

    /**
     * Get the patient that owns the CarePlan.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the provider that owns the CarePlan.
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }


}
