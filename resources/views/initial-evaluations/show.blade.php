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
                        <li class="breadcrumb-item active">@lang('Initial Evaluation Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Initial Evaluation Info')</h3>
                    @can('initial-evaluations-update')
                        <div class="card-tools">
                            <a href="{{ route('initial-evaluations.edit', $initialEvaluation) }}" class="btn btn-primary">@lang('Edit')</a>
                            <a href="{{ route('initial-evaluations.show', $initialEvaluation) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ $initialEvaluation->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $initialEvaluation->patient->name ?? 'N/A' }}</h3>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">@lang('Date')</label>
                                        <p>{{ $initialEvaluation->date }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="provider_name">@lang('Conducted by')</label>
                                        <p>{{ $initialEvaluation->provider_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reason_for_treatment">@lang('Reason for seeking treatment')</label>
                                        <p>{{ $initialEvaluation->reason_for_treatment ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="social_background">@lang('Summary of social background or specific vulnerabilities that qualify patient for assistance')</label>
                                        <p>{{ $initialEvaluation->social_background ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-header">
                        <h3 class="card-title">@lang('Clinical Status Evaluation')</h3>
                        </div>
                        <div class="card-body">
                            <h5>@lang('Vital Signs')</h5>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="temperature">@lang('Temperature (°C)')</label>
                                        <p>{{ $initialEvaluation->vital_signs['temperature'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="pulse_rate">@lang('Pulse Rate (bpm)')</label>
                                        <p>{{ $initialEvaluation->vital_signs['pulse_rate'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="respiratory_rate">@lang('Respiratory Rate')</label>
                                        <p>{{ $initialEvaluation->vital_signs['respiratory_rate'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="oxygen_saturation">@lang('SpO2 (%)')</label>
                                        <p>{{ $initialEvaluation->vital_signs['oxygen_saturation'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="systolic_bp">@lang('Systolic BP (mmHg)')</label>
                                        <p>{{ $initialEvaluation->vital_signs['systolic_bp'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="diastolic_bp">@lang('Diastolic BP (mmHg)')</label>
                                        <p>{{ $initialEvaluation->vital_signs['diastolic_bp'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="hb">@lang('Hb (g/dL)')</label>
                                        <p>{{ $initialEvaluation->vital_signs['hb'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="rbs">@lang('RBS (mg/dL)')</label>
                                        <p>{{ $initialEvaluation->vital_signs['rbs'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <h5>@lang('General Examination')</h5>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="skin_condition">@lang('Skin Color/Condition')</label>
                                        <p>{{ $initialEvaluation->skin_condition ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="edema">@lang('Edema')</label>
                                        <p>
                                            @if($initialEvaluation->edema == 'present')
                                                @lang('Present')
                                            @elseif($initialEvaluation->edema == 'absent')
                                                @lang('Absent')
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="nutritional_status">@lang('Nutritional Status')</label>
                                        <p>
                                            @if($initialEvaluation->nutritional_status == 'adequate')
                                                @lang('Adequate')
                                            @elseif($initialEvaluation->nutritional_status == 'malnourished')
                                                @lang('Malnourished')
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pain_signs">@lang('Signs of Pain (e.g., grimacing)')</label>
                                        <p>{{ $initialEvaluation->pain_signs ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hydration">@lang('Hydration Status')</label>
                                        <p>
                                            @if($initialEvaluation->hydration == 'adequate')
                                                @lang('Adequate')
                                            @elseif($initialEvaluation->hydration == 'mild')
                                                @lang('Mild dehydration')
                                            @elseif($initialEvaluation->hydration == 'severe')
                                                @lang('Severe dehydration')
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pain_level">@lang('Pain Level (Scale 0-10)')</label>
                                        <p>{{ $initialEvaluation->pain_level ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pain_location">@lang('Location of Pain')</label>
                                        <p>{{ $initialEvaluation->pain_location ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="mobility">@lang('Mobility')</label>
                                        <p>
                                            @if($initialEvaluation->mobility == 'independent')
                                                @lang('Independent')
                                            @elseif($initialEvaluation->mobility == 'partial')
                                                @lang('Partial assistance required')
                                            @elseif($initialEvaluation->mobility == 'fully_dependent')
                                                @lang('Fully dependent')
                                            @else
                                                N/A
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <h5>@lang('Systemic Assessment')</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>@lang('System')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Comments')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>@lang('Respiratory')</td>
                                            <td>
                                                @if($initialEvaluation->respiratory == 'normal')
                                                    @lang('Normal')
                                                @elseif($initialEvaluation->respiratory == 'abnormal')
                                                    @lang('Abnormal')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->respiratory_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Cardiovascular')</td>
                                            <td>
                                                @if($initialEvaluation->cardiovascular == 'normal')
                                                    @lang('Normal')
                                                @elseif($initialEvaluation->cardiovascular == 'abnormal')
                                                    @lang('Abnormal')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->cardiovascular_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Neurological')</td>
                                            <td>
                                                @if($initialEvaluation->neurological == 'normal')
                                                    @lang('Normal')
                                                @elseif($initialEvaluation->neurological == 'abnormal')
                                                    @lang('Abnormal')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->neurological_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Gastrointestinal')</td>
                                            <td>
                                                @if($initialEvaluation->gastrointestinal == 'normal')
                                                    @lang('Normal')
                                                @elseif($initialEvaluation->gastrointestinal == 'abnormal')
                                                    @lang('Abnormal')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->gastrointestinal_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Musculoskeletal')</td>
                                            <td>
                                                @if($initialEvaluation->musculoskeletal == 'normal')
                                                    @lang('Normal')
                                                @elseif($initialEvaluation->musculoskeletal == 'abnormal')
                                                    @lang('Abnormal')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->musculoskeletal_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Skin/Wounds')</td>
                                            <td>
                                                @if($initialEvaluation->skin == 'normal')
                                                    @lang('Normal')
                                                @elseif($initialEvaluation->skin == 'abnormal')
                                                    @lang('Abnormal')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->skin_comments ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5>@lang('Ongoing Medical History and Needs')</h5>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="primary_diagnosis">@lang('Primary Diagnosis')</label>
                                        <p>{{ $initialEvaluation->primary_diagnosis ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="secondary_diagnosis">@lang('Secondary Diagnosis')</label>
                                        <p>{{ $initialEvaluation->secondary_diagnosis ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="chronic_conditions">@lang('Known Chronic Conditions')</label>
                                        <p>{{ $initialEvaluation->chronic_conditions ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="current_medications">@lang('Current Medications')</label>
                                        <p>{{ $initialEvaluation->current_medications ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="allergies">@lang('Allergies')</label>
                                        <p>{{ $initialEvaluation->allergies ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
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
                                                @if($initialEvaluation->bathing == 'none')
                                                    @lang('None')
                                                @elseif($initialEvaluation->bathing == 'partial')
                                                    @lang('Partial')
                                                @elseif($initialEvaluation->bathing == 'full')
                                                    @lang('Full')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->bathing_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Dressing')</td>
                                            <td>
                                                @if($initialEvaluation->dressing == 'none')
                                                    @lang('None')
                                                @elseif($initialEvaluation->dressing == 'partial')
                                                    @lang('Partial')
                                                @elseif($initialEvaluation->dressing == 'full')
                                                    @lang('Full')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->dressing_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Eating')</td>
                                            <td>
                                                @if($initialEvaluation->eating == 'none')
                                                    @lang('None')
                                                @elseif($initialEvaluation->eating == 'partial')
                                                    @lang('Partial')
                                                @elseif($initialEvaluation->eating == 'full')
                                                    @lang('Full')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->eating_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Mobility/Transfers')</td>
                                            <td>
                                                @if($initialEvaluation->mobility_transfers == 'none')
                                                    @lang('None')
                                                @elseif($initialEvaluation->mobility_transfers == 'partial')
                                                    @lang('Partial')
                                                @elseif($initialEvaluation->mobility_transfers == 'full')
                                                    @lang('Full')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->mobility_transfers_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Toileting')</td>
                                            <td>
                                                @if($initialEvaluation->toileting == 'none')
                                                    @lang('None')
                                                @elseif($initialEvaluation->toileting == 'partial')
                                                    @lang('Partial')
                                                @elseif($initialEvaluation->toileting == 'full')
                                                    @lang('Full')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->toileting_comments ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <h5>@lang('Therapies Needed')</h5>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Physical Therapy')</label>
                                        <p>
                                            @if($initialEvaluation->physical_therapy)
                                                @lang('Yes')
                                            @else
                                                @lang('No')
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Psychiatric/Trauma Support')</label>
                                        <p>
                                            @if($initialEvaluation->psychiatric_support)
                                                @lang('Yes')
                                            @else
                                                @lang('No')
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Virtual Reality Therapy / Play Therapy')</label>
                                        <p>
                                            @if($initialEvaluation->virtual_therapy)
                                                @lang('Yes')
                                            @else
                                                @lang('No')
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Other Therapy')</label>
                                        <p>
                                            @if($initialEvaluation->other_therapy)
                                                @lang('Yes')
                                            @else
                                                @lang('No')
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="other_therapy_comments">@lang('Other Therapy Comments')</label>
                                        <p>{{ $initialEvaluation->other_therapy_comments ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
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
                                                @if($initialEvaluation->emotional_state == 'stable')
                                                    @lang('Stable')
                                                @elseif($initialEvaluation->emotional_state == 'unstable')
                                                    @lang('Unstable')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->emotional_state_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Engagement in Activities')</td>
                                            <td>
                                                @if($initialEvaluation->engagement == 'high')
                                                    @lang('High')
                                                @elseif($initialEvaluation->engagement == 'moderate')
                                                    @lang('Moderate')
                                                @elseif($initialEvaluation->engagement == 'low')
                                                    @lang('Low')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->engagement_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Interaction with Peers')</td>
                                            <td>
                                                @if($initialEvaluation->peer_interaction == 'positive')
                                                    @lang('Positive')
                                                @elseif($initialEvaluation->peer_interaction == 'neutral')
                                                    @lang('Neutral')
                                                @elseif($initialEvaluation->peer_interaction == 'negative')
                                                    @lang('Negative')
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td>{{ $initialEvaluation->peer_interaction_comments ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
