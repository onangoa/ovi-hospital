@php
    // Determine the display format based on the form type
    $displayFormat = $displayFormat ?? 'formatted'; // 'formatted' or 'form-fields'
    $patientSelectId = $patientSelectId ?? 'patient_id';
    $patientSelectName = $patientSelectName ?? 'patient_id';
    $required = $required ?? true;
@endphp

<div class="patient-details-container" style="display: none;">
    @if($displayFormat === 'formatted')
        <!-- Formatted display style (for initial-evaluations, prescriptions, etc.) -->
        <div class="card mb-3">
            <div class="card-header bg-info text-white">
                {{ __('Patient Details') }}
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        <p><strong>{{ __('Age') }}:</strong> <span id="patient-age"></span></p>
                        <p><strong>{{ __('Weight') }}:</strong> <span id="patient-weight"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>{{ __('Height') }}:</strong> <span id="patient-height"></span></p>
                        <p><strong>{{ __('Gender') }}:</strong> <span id="patient-gender"></span></p>
                    </div>
                    <div class="col-md-4">
                        <p><strong>{{ __('Blood Group') }}:</strong> <span id="patient-blood-group"></span></p>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Form fields display style (for lab-requests, etc.) -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="age">{{ __('Age') }}</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                        </div>
                        <input type="text" name="age" id="age" class="form-control" placeholder="{{ __('Age') }}" readonly>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-label">{{ __('Sex') }}</label>
                    <div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sex" id="male" value="male" onclick="return false;">
                            <label class="form-check-label" for="male">{{ __('Male') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="sex" id="female" value="female" onclick="return false;">
                            <label class="form-check-label" for="female">{{ __('Female') }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="blood_group">{{ __('Blood Group') }}</label>
                    <input type="text" name="blood_group" id="blood_group" class="form-control" placeholder="{{ __('Blood Group') }}" readonly>
                </div>
            </div>
        </div>
    @endif
</div>
