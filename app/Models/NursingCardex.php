<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NursingCardex extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'patient_id',
        'vital_signs',
        'brief_report',
        'nurse_on_duty_name',
        'nurse_on_duty_id',
        'duty_end_time',
    ];

    protected $casts = [
        'vital_signs' => 'array',
        'date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function nurseOnDuty()
    {
        return $this->belongsTo(User::class, 'nurse_on_duty_id');
    }
}
