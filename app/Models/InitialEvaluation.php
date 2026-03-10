<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InitialEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'provider_id',
        'date',
        'provider_name',
        'reason_for_treatment',
        'social_background',
        'skin_condition',
        'edema',
        'nutritional_status',
        'pain_signs',
        'hydration',
        'pain_location',
        'mobility',
        'respiratory',
        'respiratory_comments',
        'cardiovascular',
        'cardiovascular_comments',
        'neurological',
        'neurological_comments',
        'gastrointestinal',
        'gastrointestinal_comments',
        'musculoskeletal',
        'musculoskeletal_comments',
        'skin',
        'skin_comments',
        'primary_diagnosis',
        'secondary_diagnosis',
        'chronic_conditions',
        'current_medications',
        'allergies',
        'bathing',
        'bathing_comments',
        'dressing',
        'dressing_comments',
        'eating',
        'eating_comments',
        'mobility_transfers',
        'mobility_transfers_comments',
        'toileting',
        'toileting_comments',
        'physical_therapy',
        'psychiatric_support',
        'virtual_therapy',
        'other_therapy',
        'other_therapy_comments',
        'emotional_state',
        'emotional_state_comments',
        'engagement',
        'engagement_comments',
        'peer_interaction',
        'peer_interaction_comments',
        'vital_signs',
    ];

    protected $casts = [
        'vital_signs' => 'array',
    ];

    /**
     * Get the patient that owns the InitialEvaluation.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the provider that owns the InitialEvaluation.
     */
    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}