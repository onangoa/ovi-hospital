<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ward extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'capacity',
        'status',
        'company_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function patients()
    {
        return $this->belongsToMany(User::class, 'patient_ward', 'ward_id', 'patient_id')
                    ->withPivot('created_at', 'discharged_at')
                    ->withTimestamps();
    }

    public function doctors()
    {
        return $this->belongsToMany(User::class, 'doctor_assignments', 'ward_id', 'doctor_id')
                    ->where('doctor_assignments.patient_id', null) // Only get ward assignments, not patient appointments
                    ->withPivot('created_at', 'appointment_date')
                    ->withTimestamps();
    }
    
    /**
     * Get all doctor assignments with their slots
     * This allows the same doctor to be assigned multiple times with different slots
     */
    public function doctorAssignments()
    {
        return $this->hasMany(DoctorAssignment::class, 'ward_id');
    }
}
