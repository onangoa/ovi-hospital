<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class VitalSignConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'field_name',
        'display_name',
        'field_type',
        'field_options',
        'min_value',
        'max_value',
        'unit',
        'display_order',
        'is_required',
        'is_active',
        'category',
    ];

    protected $casts = [
        'field_options' => 'array',
        'min_value' => 'decimal:2',
        'max_value' => 'decimal:2',
        'is_required' => 'boolean',
        'is_active' => 'boolean',
        'display_order' => 'integer',
    ];

    /**
     * Get the clinical forms that use this vital sign.
     */
    public function clinicalForms(): BelongsToMany
    {
        return $this->belongsToMany(ClinicalFormVitalSign::class, 'clinical_form_vital_sign_pivot')
            ->withPivot(['is_required', 'display_order'])
            ->withTimestamps();
    }

    /**
     * Scope to get only active vital signs.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to get vital signs by category.
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope to get vital signs ordered by display order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc')->orderBy('display_name', 'asc');
    }
}