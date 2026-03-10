<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TherapyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'physiotherapist_id',
        'session_time',
        'session_summary',
        'patient_id',
        'participant_ids',
        'group_session_summary',
        'overall_observations',
        'equipment_clean_up',
        'additional_comments',
        'ward_id',
    ];

    protected $casts = [
        'date' => 'date',
        'participant_ids' => 'array',
    ];

    public function physiotherapist()
    {
        return $this->belongsTo(User::class, 'physiotherapist_id');
    }

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }
}
