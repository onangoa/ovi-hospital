@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('initial-evaluations.index') }}">@lang('Initial Evaluation')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Initial Evaluation')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Edit Initial Evaluation')</h3>
                </div>
                <div class="card-body">
                    <form id="wizardForm" class="form-material form-horizontal" action="{{ route('initial-evaluations.update', $initialEvaluation) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        <div class="card mb-4 step-content" id="step1">
                            <div class="card-header">
                            <h3 class="card-title">@lang('Patient Information')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="patient_id">@lang('Patient Name') <b class="ambitious-crimson">*</b></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-injured"></i></span>
                                                </div>
                                                <select name="patient_id" id="patient_id" class="patient-select form-control custom-width-100 select2 @error('patient_id') is-invalid @enderror" required>
                                                    <option value="">--@lang('Select Patient')--</option>
                                                    @foreach ($patients as $patient)
                                                        <option value="{{ $patient->id }}" @if($patient->id == old('patient_id', $initialEvaluation->patient_id)) selected @endif>{{ $patient->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('patient_id')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="date">@lang('Date') <b class="ambitious-crimson">*</b></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                                </div>
                                                <input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', $initialEvaluation->date) }}" readonly>
                                                @error('date')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="provider_name">@lang('Conducted by')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                                </div>
                                                <input type="text" name="provider_name" id="provider_name" class="form-control @error('provider_name') is-invalid @enderror" placeholder="@lang('Conducted by')" value="{{ $currentUser->name }}" readonly>
                                                @error('provider_name')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="reason_for_treatment" class="form-label">@lang('Reason for seeking treatment')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-notes-medical"></i></span>
                                                </div>
                                                <textarea name="reason_for_treatment" class="form-control @error('reason_for_treatment') is-invalid @enderror" id="reason_for_treatment" rows="3" placeholder="@lang('Describe the reason for the visit')">{{ old('reason_for_treatment', $initialEvaluation->reason_for_treatment) }}</textarea>
                                                @error('reason_for_treatment')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="social_background" class="form-label">@lang('Summary of social background or specific vulnerabilities that qualify patient for assistance')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                </div>
                                                <textarea name="social_background" class="form-control @error('social_background') is-invalid @enderror" id="social_background" rows="3" placeholder="@lang('Provide a summary of the patients background')">{{ old('social_background', $initialEvaluation->social_background) }}</textarea>
                                                @error('social_background')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if($initialEvaluation->vital_signs)
                                    @include('components.vital-signs', ['vital_signs' => $initialEvaluation->vital_signs, 'form_name' => 'initial_evaluation'])
                        @else
                            @include('components.vital-signs', ['form_name' => 'initial_evaluation'])
                        @endif
                        <div class="card mb-4 step-content" id="step2">
                            <div class="card-header">
                            <h3 class="card-title">@lang('Clinical Status Evaluation')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mb-3">
                                </div>
                                <h5>@lang('General Examination')</h5>
                                <div class="mb-3">
                                    <label for="skin_condition" class="form-label">@lang('Skin Color/Condition')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        </div>
                                        <textarea name="skin_condition" class="form-control @error('skin_condition') is-invalid @enderror" id="skin_condition" rows="2">{{ old('skin_condition', $initialEvaluation->skin_condition) }}</textarea>
                                        @error('skin_condition')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Edema')</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="edema" id="edemaPresent" value="present" {{ old('edema', $initialEvaluation->edema) == 'present' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edemaPresent">
                                            @lang('Present')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="edema" id="edemaAbsent" value="absent" {{ old('edema', $initialEvaluation->edema) == 'absent' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="edemaAbsent">
                                            @lang('Absent')
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Nutritional Status')</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="nutritional_status" id="nutritionalAdequate" value="adequate" {{ old('nutritional_status', $initialEvaluation->nutritional_status) == 'adequate' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nutritionalAdequate">
                                            @lang('Adequate')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="nutritional_status" id="nutritionalMalnourished" value="malnourished" {{ old('nutritional_status', $initialEvaluation->nutritional_status) == 'malnourished' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="nutritionalMalnourished">
                                            @lang('Malnourished')
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="pain_signs" class="form-label">@lang('Signs of Pain (e.g., grimacing)')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-frown"></i></span>
                                        </div>
                                        <textarea name="pain_signs" class="form-control @error('pain_signs') is-invalid @enderror" id="pain_signs" rows="2">{{ old('pain_signs', $initialEvaluation->pain_signs) }}</textarea>
                                        @error('pain_signs')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <h5>@lang('Hydration and Pain')</h5>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Hydration Status')</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hydration" id="hydrationAdequate" value="adequate" {{ old('hydration', $initialEvaluation->hydration) == 'adequate' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hydrationAdequate">
                                            @lang('Adequate')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hydration" id="hydrationMild" value="mild" {{ old('hydration', $initialEvaluation->hydration) == 'mild' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hydrationMild">
                                            @lang('Mild dehydration')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="hydration" id="hydrationSevere" value="severe" {{ old('hydration', $initialEvaluation->hydration) == 'severe' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="hydrationSevere">
                                            @lang('Severe dehydration')
                                        </label>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="pain_level" class="form-label">@lang('Pain Level (Scale 0-10)')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-tachometer-alt"></i></span>
                                        </div>
                                        <input type="number" name="pain_level" class="form-control @error('pain_level') is-invalid @enderror" id="pain_level" min="0" max="10" value="{{ old('pain_level', $initialEvaluation->pain_level) }}">
                                        @error('pain_level')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="pain_location" class="form-label">@lang('Location of Pain')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        </div>
                                        <input type="text" name="pain_location" class="form-control @error('pain_location') is-invalid @enderror" id="pain_location" value="{{ old('pain_location', $initialEvaluation->pain_location) }}">
                                        @error('pain_location')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">@lang('Mobility')</label><br>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mobility" id="mobilityIndependent" value="independent" {{ old('mobility', $initialEvaluation->mobility) == 'independent' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mobilityIndependent">
                                            @lang('Independent')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mobility" id="mobilityPartial" value="partial" {{ old('mobility', $initialEvaluation->mobility) == 'partial' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mobilityPartial">
                                            @lang('Partial assistance required')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="mobility" id="mobilityDependent" value="fully_dependent" {{ old('mobility', $initialEvaluation->mobility) == 'fully_dependent' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="mobilityDependent">
                                            @lang('Fully dependent')
                                        </label>
                                    </div>
                                </div>
                                <h5>@lang('Systemic Assessment')</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>@lang('System')</th>
                                                <th>@lang('Normal/Abnormal')</th>
                                                <th>@lang('Comments')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>@lang('Respiratory')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="respiratory" id="respiratoryNormal" value="normal" {{ old('respiratory', $initialEvaluation->respiratory) == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="respiratoryNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="respiratory" id="respiratoryAbnormal" value="abnormal" {{ old('respiratory', $initialEvaluation->respiratory) == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="respiratoryAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="respiratory_comments" class="form-control" value="{{ old('respiratory_comments', $initialEvaluation->respiratory_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Cardiovascular')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="cardiovascular" id="cardiovascularNormal" value="normal" {{ old('cardiovascular', $initialEvaluation->cardiovascular) == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="cardiovascularNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="cardiovascular" id="cardiovascularAbnormal" value="abnormal" {{ old('cardiovascular', $initialEvaluation->cardiovascular) == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="cardiovascularAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="cardiovascular_comments" class="form-control" value="{{ old('cardiovascular_comments', $initialEvaluation->cardiovascular_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Neurological')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="neurological" id="neurologicalNormal" value="normal" {{ old('neurological', $initialEvaluation->neurological) == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="neurologicalNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="neurological" id="neurologicalAbnormal" value="abnormal" {{ old('neurological', $initialEvaluation->neurological) == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="neurologicalAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="neurological_comments" class="form-control" value="{{ old('neurological_comments', $initialEvaluation->neurological_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Gastrointestinal')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gastrointestinal" id="gastrointestinalNormal" value="normal" {{ old('gastrointestinal', $initialEvaluation->gastrointestinal) == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gastrointestinalNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="gastrointestinal" id="gastrointestinalAbnormal" value="abnormal" {{ old('gastrointestinal', $initialEvaluation->gastrointestinal) == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="gastrointestinalAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="gastrointestinal_comments" class="form-control" value="{{ old('gastrointestinal_comments', $initialEvaluation->gastrointestinal_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Musculoskeletal')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="musculoskeletal" id="musculoskeletalNormal" value="normal" {{ old('musculoskeletal', $initialEvaluation->musculoskeletal) == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="musculoskeletalNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="musculoskeletal" id="musculoskeletalAbnormal" value="abnormal" {{ old('musculoskeletal', $initialEvaluation->musculoskeletal) == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="musculoskeletalAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="musculoskeletal_comments" class="form-control" value="{{ old('musculoskeletal_comments', $initialEvaluation->musculoskeletal_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Skin/Wounds')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="skin" id="skinNormal" value="normal" {{ old('skin', $initialEvaluation->skin) == 'normal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="skinNormal">@lang('Normal')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="skin" id="skinAbnormal" value="abnormal" {{ old('skin', $initialEvaluation->skin) == 'abnormal' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="skinAbnormal">@lang('Abnormal')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="skin_comments" class="form-control" value="{{ old('skin_comments', $initialEvaluation->skin_comments) }}"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h5>@lang('Ongoing Medical History and Needs')</h5>
                                <div class="mb-3">
                                    <label for="primary_diagnosis" class="form-label">@lang('Primary Diagnosis')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-stethoscope"></i></span>
                                        </div>
                                        <textarea name="primary_diagnosis" class="form-control @error('primary_diagnosis') is-invalid @enderror" id="primary_diagnosis" rows="2">{{ old('primary_diagnosis', $initialEvaluation->primary_diagnosis) }}</textarea>
                                        @error('primary_diagnosis')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="secondary_diagnosis" class="form-label">@lang('Secondary Diagnosis')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-notes-medical"></i></span>
                                        </div>
                                        <textarea name="secondary_diagnosis" class="form-control @error('secondary_diagnosis') is-invalid @enderror" id="secondary_diagnosis" rows="2">{{ old('secondary_diagnosis', $initialEvaluation->secondary_diagnosis) }}</textarea>
                                        @error('secondary_diagnosis')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="chronic_conditions" class="form-label">@lang('Known Chronic Conditions')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                        </div>
                                        <textarea name="chronic_conditions" class="form-control @error('chronic_conditions') is-invalid @enderror" id="chronic_conditions" rows="2">{{ old('chronic_conditions', $initialEvaluation->chronic_conditions) }}</textarea>
                                        @error('chronic_conditions')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="current_medications" class="form-label">@lang('Current Medications')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                        </div>
                                        <textarea name="current_medications" class="form-control @error('current_medications') is-invalid @enderror" id="current_medications" rows="2">{{ old('current_medications', $initialEvaluation->current_medications) }}</textarea>
                                        @error('current_medications')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="allergies" class="form-label">@lang('Allergies')</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-allergies"></i></span>
                                        </div>
                                        <textarea name="allergies" class="form-control @error('allergies') is-invalid @enderror" id="allergies" rows="2">{{ old('allergies', $initialEvaluation->allergies) }}</textarea>
                                        @error('allergies')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 step-content" id="step3">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Daily Living and Therapy Needs')</h3>
                            </div>
                            <div class="card-body">
                                <h5>@lang('Activities of Daily Living (ADLs)')</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>@lang('Activity')</th>
                                                <th>@lang('Level of Assistance')</th>
                                                <th>@lang('Comments')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>@lang('Bathing')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bathing" id="bathingNone" value="none" {{ old('bathing', $initialEvaluation->bathing) == 'none' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bathingNone">@lang('None')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bathing" id="bathingPartial" value="partial" {{ old('bathing', $initialEvaluation->bathing) == 'partial' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bathingPartial">@lang('Partial')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="bathing" id="bathingFull" value="full" {{ old('bathing', $initialEvaluation->bathing) == 'full' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="bathingFull">@lang('Full')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="bathing_comments" class="form-control" value="{{ old('bathing_comments', $initialEvaluation->bathing_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Dressing')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="dressing" id="dressingNone" value="none" {{ old('dressing', $initialEvaluation->dressing) == 'none' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="dressingNone">@lang('None')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="dressing" id="dressingPartial" value="partial" {{ old('dressing', $initialEvaluation->dressing) == 'partial' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="dressingPartial">@lang('Partial')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="dressing" id="dressingFull" value="full" {{ old('dressing', $initialEvaluation->dressing) == 'full' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="dressingFull">@lang('Full')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="dressing_comments" class="form-control" value="{{ old('dressing_comments', $initialEvaluation->dressing_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Eating')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="eating" id="eatingNone" value="none" {{ old('eating', $initialEvaluation->eating) == 'none' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="eatingNone">@lang('None')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="eating" id="eatingPartial" value="partial" {{ old('eating', $initialEvaluation->eating) == 'partial' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="eatingPartial">@lang('Partial')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="eating" id="eatingFull" value="full" {{ old('eating', $initialEvaluation->eating) == 'full' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="eatingFull">@lang('Full')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="eating_comments" class="form-control" value="{{ old('eating_comments', $initialEvaluation->eating_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Mobility/Transfers')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="mobility_transfers" id="mobilityNone" value="none" {{ old('mobility_transfers', $initialEvaluation->mobility_transfers) == 'none' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mobilityNone">@lang('None')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="mobility_transfers" id="mobilityPartial" value="partial" {{ old('mobility_transfers', $initialEvaluation->mobility_transfers) == 'partial' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mobilityPartial">@lang('Partial')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="mobility_transfers" id="mobilityFull" value="full" {{ old('mobility_transfers', $initialEvaluation->mobility_transfers) == 'full' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="mobilityFull">@lang('Full')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="mobility_transfers_comments" class="form-control" value="{{ old('mobility_transfers_comments', $initialEvaluation->mobility_transfers_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Toileting')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="toileting" id="toiletingNone" value="none" {{ old('toileting', $initialEvaluation->toileting) == 'none' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="toiletingNone">@lang('None')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="toileting" id="toiletingPartial" value="partial" {{ old('toileting', $initialEvaluation->toileting) == 'partial' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="toiletingPartial">@lang('Partial')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="toileting" id="toiletingFull" value="full" {{ old('toileting', $initialEvaluation->toileting) == 'full' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="toiletingFull">@lang('Full')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="toileting_comments" class="form-control" value="{{ old('toileting_comments', $initialEvaluation->toileting_comments) }}"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <h5>@lang('Therapies Needed')</h5>
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="physical_therapy" id="physicalTherapy" value="1" {{ old('physical_therapy', $initialEvaluation->physical_therapy) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="physicalTherapy">
                                            @lang('Physical Therapy')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="psychiatric_support" id="psychiatricSupport" value="1" {{ old('psychiatric_support', $initialEvaluation->psychiatric_support) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="psychiatricSupport">
                                            @lang('Psychiatric/Trauma Support')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="virtual_therapy" id="virtualTherapy" value="1" {{ old('virtual_therapy', $initialEvaluation->virtual_therapy) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="virtualTherapy">
                                            @lang('Virtual Reality Therapy / Play Therapy')
                                        </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" name="other_therapy" id="otherTherapy" value="1" {{ old('other_therapy', $initialEvaluation->other_therapy) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="otherTherapy">
                                            @lang('Other:')
                                        </label>
                                    </div>
                                    <div class="input-group mt-2 mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fas fa-comment-medical"></i></span>
                                        </div>
                                        <textarea name="other_therapy_comments" class="form-control @error('other_therapy_comments') is-invalid @enderror" id="otherTherapyComments" rows="2" placeholder="@lang('Specify other therapies')">{{ old('other_therapy_comments', $initialEvaluation->other_therapy_comments) }}</textarea>
                                        @error('other_therapy_comments')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4 step-content" id="step4">
                            <div class="card-header">
                            <h3 class="card-title">@lang('Social and Emotional Well-Being')</h3>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>@lang('Factor')</th>
                                                <th>@lang('Observation')</th>
                                                <th>@lang('Comments')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>@lang('Emotional State')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="emotional_state" id="emotionalStable" value="stable" {{ old('emotional_state', $initialEvaluation->emotional_state) == 'stable' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="emotionalStable">@lang('Stable')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="emotional_state" id="emotionalUnstable" value="unstable" {{ old('emotional_state', $initialEvaluation->emotional_state) == 'unstable' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="emotionalUnstable">@lang('Unstable')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="emotional_state_comments" class="form-control" value="{{ old('emotional_state_comments', $initialEvaluation->emotional_state_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Engagement in Activities')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="engagement" id="engagementHigh" value="high" {{ old('engagement', $initialEvaluation->engagement) == 'high' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="engagementHigh">@lang('High')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="engagement" id="engagementModerate" value="moderate" {{ old('engagement', $initialEvaluation->engagement) == 'moderate' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="engagementModerate">@lang('Moderate')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="engagement" id="engagementLow" value="low" {{ old('engagement', $initialEvaluation->engagement) == 'low' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="engagementLow">@lang('Low')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="engagement_comments" class="form-control" value="{{ old('engagement_comments', $initialEvaluation->engagement_comments) }}"></td>
                                            </tr>
                                            <tr>
                                                <td>@lang('Interaction with Peers')</td>
                                                <td>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="peer_interaction" id="peerPositive" value="positive" {{ old('peer_interaction', $initialEvaluation->peer_interaction) == 'positive' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="peerPositive">@lang('Positive')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="peer_interaction" id="peerNeutral" value="neutral" {{ old('peer_interaction', $initialEvaluation->peer_interaction) == 'neutral' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="peerNeutral">@lang('Neutral')</label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="peer_interaction" id="peerNegative" value="negative" {{ old('peer_interaction', $initialEvaluation->peer_interaction) == 'negative' ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="peerNegative">@lang('Negative')</label>
                                                    </div>
                                                </td>
                                                <td><input type="text" name="peer_interaction_comments" class="form-control" value="{{ old('peer_interaction_comments', $initialEvaluation->peer_interaction_comments) }}"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('initial-evaluations.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('footer')
        <script src="{{ asset('assets/js/custom/patient-details.js') }}"></script>
        <script src="{{ asset('assets/js/custom/vital-signs.js') }}"></script>
@endpush
