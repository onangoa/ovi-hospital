<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class User
 * @package App
 * @category model
 */
class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'address',
        'photo',
        'company_id',
        'locale',
        'date_of_birth',
        'gender',
        'blood_group',
        'status',
        'weight',
        'height',
        'guardian_name',
        'guardian_phone',
        'guardian_email',
        'guardian_address',
        'guardian_relation',
    ];

    protected $appends = ['age'];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Has many relation with complains
     *
     * @return mixed
     */
    public function companies()
    {
        return $this->morphToMany(Company::class, 'user', 'user_companies', 'user_id', 'company_id');
    }


    public function patientAppointments()
    {
        return $this->hasMany(DoctorAssignment::class, 'patient_id');
    }

    public function doctorAppointments()
    {
        return $this->hasMany(DoctorAssignment::class, 'doctor_id');
    }

    public function getPhotoUrlAttribute()
    {
        if ($this->photo)
            return asset($this->photo);
        else
            return asset('assets/images/placeholder.jpg');
    }

    public function getAgeAttribute()
    {
        if ($this->date_of_birth) {
            $birthDate = \Carbon\Carbon::parse($this->date_of_birth);
            $now = \Carbon\Carbon::now();
            
            $years = $birthDate->diffInYears($now);
            
            if ($years > 0) {
                return $years . ' Y';
            } else {
                $months = $birthDate->diffInMonths($now);
                return '0Y ' . $months . ' months';
            }
        }
        return null;
    }

    public function patientCaseStudy()
    {
        return $this->hasOne(PatientCaseStudy::class);
    }

    public function labReports()
    {
        return $this->hasMany(LabReport::class, 'patient_id');
    }

    public function carePreferences()
    {
        return $this->hasOne(CarePreference::class, 'user_id');
    }

    public function cviScores()
    {
        return $this->hasMany(ChildVitalityIndexScore::class, 'patient_id');
    }

    public function wards()
    {
        return $this->belongsToMany(Ward::class, 'patient_ward', 'patient_id', 'ward_id')
                    ->withPivot('created_at', 'discharged_at')
                    ->withTimestamps();
    }

    public function medicalReferrals()
    {
        return $this->hasMany(MedicalReferral::class, 'patient_id');
    }

    public function radiologyRequests()
    {
        return $this->hasMany(RadiologyRequest::class, 'patient_id');
    }

    public function carePlans()
    {
        return $this->hasMany(CarePlan::class, 'patient_id');
    }

    public function wardRoundNotes()
    {
        return $this->hasMany(WardRoundNote::class, 'patient_id');
    }

    public function therapyReports()
    {
        return $this->hasMany(TherapyReport::class, 'patient_id');
    }

    public function caregiverDailyReports()
    {
        return $this->hasMany(CaregiverDailyReport::class, 'patient_id');
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class, 'patient_id');
    }

    public function doctorDetails()
    {
        return $this->hasOne(DoctorDetail::class);
    }
}
