<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaregiverDailyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'date',
        'breakfast',
        'lunch',
        'dinner',
        'mood',
        'favorite_activity',
        'pain_level',
        'concerns',
        'provider_id'
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
