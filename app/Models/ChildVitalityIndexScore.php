<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildVitalityIndexScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'nutritionalStatus',
        'developmentallyDelayed',
        'chronicConditions',
        'mentalHealth',
        'physicalDisabilities',
        'communicationAbilities',
        'vaccineStatus',
        'familialInstability',
        'poverty',
        'institutionalized',
        'insecureShelter',
        'psychologicalTrauma',
        'socialIsolation',
        'discrimination',
        'conflictArea',
        'healthcareAccess',
        'waterSource',
        'sanitation',
        'schoolStatus',
        'diseaseOutbreaks',
        'score',
        'notes',
    ];



    /**
     * Get the patient that owns the CVI.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the vitality score interpretation.
     *
     * @return string
     */
    public function getVitalityScoreAttribute()
    {
        $score = $this->score;
        if ($score <= 59) {
            return 'Critical Vitality Score';
        } elseif ($score <= 79) {
            return 'Low Child Vitality Score';
        } elseif ($score <= 89) {
            return 'Moderate Vitality Score';
        } else {
            return 'High Vitality Score';
        }
    }
}
