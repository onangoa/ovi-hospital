<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ClinicalFormVitalSign extends Model
{
    use HasFactory;

    protected $fillable = [
        'form_name',
        'form_display_name',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the vital signs associated with this clinical form.
     */
    public function vitalSigns(): BelongsToMany
    {
        return $this->belongsToMany(VitalSignConfig::class, 'clinical_form_vital_sign_pivot')
            ->withPivot(['is_required', 'display_order'])
            ->withTimestamps()
            ->orderBy('pivot_display_order', 'asc');
    }

    /**
     * Scope to get only active clinical forms.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get vital signs for this form that are active and ordered.
     */
    public function getActiveVitalSigns()
    {
        return $this->vitalSigns()->active()->orderBy('pivot_display_order', 'asc');
    }
}