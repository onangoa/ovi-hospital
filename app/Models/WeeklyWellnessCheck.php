<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyWellnessCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'conducted_by',
        'vital_signs',
        'full_meals',
        'partial_meals',
        'minimal_meals',
        'skin_wounds',
        'mobility',
        'mobility_notes',
        'sleep',
        'mood',
        'engagement',
        'behavior_changes',
        'with_caregivers',
        'with_peers',
        'communication',
        'pain_indicators',
        'comfort',
        'medication',
        'signs_of_illness',
        'hydration',
        'environment',
        'progress',
        'next_steps',
    ];

    protected $casts = [
        'date' => 'date',
        'full_meals' => 'boolean',
        'partial_meals' => 'boolean',
        'minimal_meals' => 'boolean',
        'vital_signs' => 'array',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function conductedBy()
    {
        return $this->belongsTo(User::class, 'conducted_by');
    }
}
