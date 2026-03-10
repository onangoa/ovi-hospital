@php
    // Ensure $vital_signs is always defined
    $vital_signs = $vital_signs ?? [];

    // Get the form name from the parameter or use a default
    $formName = $form_name ?? 'default';
    // Try to get the vital signs for this specific form
    $clinicalForm = \App\Models\ClinicalFormVitalSign::where('form_name', $formName)
        ->first();

    // If no specific form configuration is found, use the default vital signs
    
    if ($clinicalForm) {
        // Only show vital signs that are explicitly included in this clinical form
        $vitalSignsForForm = $clinicalForm->vitalSigns;
    } else {
        // Fallback to the default vital signs (active ones, ordered by display_order)
        $vitalSignsForForm = \App\Models\VitalSignConfig::active()->ordered()->get();
        
    }

    // Prepare JS-friendly array for @json()
    $vitalSignsJs = $vitalSignsForForm->map(function($vs) {
        return [
            'field_name' => $vs->field_name,
            'display_name' => $vs->display_name,
            'field_type' => $vs->field_type,
            'min_value' => $vs->min_value,
            'max_value' => $vs->max_value,
            'unit' => $vs->unit,
            'is_required' => isset($vs->pivot) ? $vs->pivot->is_required : $vs->is_required,
        ];
    })->toArray();
@endphp

<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">@lang('Vital Signs')</h5>
    </div>
    <div class="card-body">
        <div class="vital-signs-form">
    <div class="row">
        @foreach($vitalSignsForForm as $vitalSign)
            <div class="col-md-3">
                <div class="form-group">
                    <label for="{{ $vitalSign->field_name }}">
                        {{ $vitalSign->display_name }}
                        @if($vitalSign->unit)
                            <small class="text-muted">({{ $vitalSign->unit }})</small>
                        @endif
                        @if(isset($vitalSign->pivot) && $vitalSign->pivot->is_required)
                            <span class="text-danger">*</span>
                        @endif
                    </label>

                    @if($vitalSign->field_type == 'number')
                        <input type="number"
                               step="0.1"
                               name="vital_signs[{{ $vitalSign->field_name }}]"
                               class="form-control @error('vital_signs.' . $vitalSign->field_name) is-invalid @enderror"
                               id="{{ $vitalSign->field_name }}"
                               value="{{ $vital_signs[$vitalSign->field_name] ?? '' }}"
                               @if($vitalSign->min_value !== null) min="{{ $vitalSign->min_value }}" @endif
                               @if($vitalSign->max_value !== null) max="{{ $vitalSign->max_value }}" @endif
                               @if(isset($vitalSign->pivot) && $vitalSign->pivot->is_required) required @endif>
                    
                    @elseif($vitalSign->field_type == 'select')
                        <select name="vital_signs[{{ $vitalSign->field_name }}]"
                                class="form-control @error('vital_signs.' . $vitalSign->field_name) is-invalid @enderror"
                                id="{{ $vitalSign->field_name }}"
                                @if(isset($vitalSign->pivot) && $vitalSign->pivot->is_required) required @endif>
                            <option value="">{{ __('Select') }} {{ $vitalSign->display_name }}</option>
                            @if($vitalSign->field_options)
                                @foreach($vitalSign->field_options as $value => $label)
                                    <option value="{{ $value }}"
                                        {{ ($vital_signs[$vitalSign->field_name] ?? '') == $value ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    
                    @else
                        <input type="text"
                               name="vital_signs[{{ $vitalSign->field_name }}]"
                               class="form-control @error('vital_signs.' . $vitalSign->field_name) is-invalid @enderror"
                               id="{{ $vitalSign->field_name }}"
                               value="{{ $vital_signs[$vitalSign->field_name] ?? '' }}"
                               @if(isset($vitalSign->pivot) && $vitalSign->pivot->is_required) required @endif>
                    @endif

                    @error('vital_signs.' . $vitalSign->field_name)
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            @if($loop->iteration % 4 == 0 && !$loop->last)
                </div><div class="row">
            @endif
        @endforeach
        </div>
    </div>
</div>
</div>
@once
    @push('scripts')
    <script>
        // Store the vital signs configuration for JavaScript use
        window.vitalSignsConfig = @json($vitalSignsJs);
    </script>
    @endpush
@endonce
