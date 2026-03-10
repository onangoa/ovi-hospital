<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorAssignment extends Model
{
    protected $fillable = [
        'doctor_id',
        'patient_id',
        'ward_id',
        'company_id',
        'weekday',
        'start_time',
        'end_time',
        'appointment_date',
        'problem',
        'status',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'start_time' => 'datetime:H:i:s',
        'end_time' => 'datetime:H:i:s',
    ];

    /**
     * Get the doctor that owns the assignment.
     */
    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    /**
     * Get the patient that owns the assignment.
     */
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    /**
     * Get the ward that owns the assignment.
     */
    public function ward()
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    /**
     * Scope to get only appointment assignments.
     */
    public function scopeAppointments($query)
    {
        return $query->whereNotNull('patient_id');
    }

    /**
     * Scope to get only ward assignments (without specific patients).
     */
    public function scopeWardAssignments($query)
    {
        return $query->whereNull('patient_id');
    }

    /**
     * Scope to get assignments for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->where('appointment_date', $date);
    }

    /**
     * Scope to get assignments for a specific doctor.
     */
    public function scopeForDoctor($query, $doctorId)
    {
        return $query->where('doctor_id', $doctorId);
    }

    /**
     * Scope to get assignments for a specific ward.
     */
    public function scopeForWard($query, $wardId)
    {
        return $query->where('ward_id', $wardId);
    }

    /**
     * Check if this is an appointment assignment.
     */
    public function isAppointment()
    {
        return !is_null($this->patient_id);
    }

    /**
     * Check if this is a ward assignment.
     */
    public function isWardAssignment()
    {
        return is_null($this->patient_id);
    }

    /**
     * Check if the given time range overlaps with existing assignments for a doctor
     *
     * @param int $doctorId
     * @param string $startTime
     * @param string $endTime
     * @param string|null $date
     * @param string|null $weekday
     * @param int|null $excludeId
     * @return bool
     */
    public static function hasOverlappingAssignment($doctorId, $startTime, $endTime, $date = null, $weekday = null, $excludeId = null)
    {
        $query = self::where('doctor_id', $doctorId)
            ->where(function ($q) use ($startTime, $endTime) {
                // Check for overlapping time ranges
                $q->where(function ($subQ) use ($startTime, $endTime) {
                    // Case 1: New assignment starts during an existing assignment
                    $subQ->where('start_time', '<=', $startTime)
                         ->where('end_time', '>', $startTime);
                })->orWhere(function ($subQ) use ($startTime, $endTime) {
                    // Case 2: New assignment ends during an existing assignment
                    $subQ->where('start_time', '<', $endTime)
                         ->where('end_time', '>=', $endTime);
                })->orWhere(function ($subQ) use ($startTime, $endTime) {
                    // Case 3: New assignment completely contains an existing assignment
                    $subQ->where('start_time', '>=', $startTime)
                         ->where('end_time', '<=', $endTime);
                });
            });

        // Filter by date or weekday
        if ($date) {
            $query->where('appointment_date', $date);
        } elseif ($weekday) {
            $query->where('weekday', $weekday);
        }

        // Exclude current assignment when editing
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        // Only check assignments that are not cancelled
        $query->where('status', '!=', 'cancelled');

        return $query->exists();
    }
}