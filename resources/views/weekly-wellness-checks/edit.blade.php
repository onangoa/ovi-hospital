@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('weekly-wellness-checks.index') }}">@lang('Weekly Wellness Checks')</a></li>
                        <li class="breadcrumb-item active">@lang('Edit Weekly Wellness Check')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Weekly Wellness Check Evaluation')</h3>
                </div>
                <div class="card-body">
                    <form id="weeklyWellnessCheckForm" class="form-material form-horizontal" action="{{ route('weekly-wellness-checks.update', $weeklyWellnessCheck) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials.patient-details', ['displayFormat' => 'formatted'])
                        
                        <!-- Evaluation Details Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Evaluation Details')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
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
                                                        <option value="{{ $patient->id }}" @if($patient->id == old('patient_id', $weeklyWellnessCheck->patient_id)) selected @endif>{{ $patient->name }}</option>
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
                                            <label for="date">@lang('Date')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="far fa-calendar-check"></i></span>
                                                </div>
                                                <input type="text" name="date" id="date" class="form-control @error('date') is-invalid @enderror" placeholder="@lang('Date')" value="{{ old('date', optional($weeklyWellnessCheck->date)->format('Y-m-d')) }}" readonly>

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
                                            <label for="conducted_by">@lang('Conducted By')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $weeklyWellnessCheck->conductedBy->name ?? '' }}" readonly>
                                                <input type="hidden" name="conducted_by" value="{{ $weeklyWellnessCheck->conducted_by }}">
                                                @error('conducted_by')
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
                        <div class="col-md-12">
                            <div id="vital-signs-container"></div>
                        </div>
                        <!-- Physical Health Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Physical Health')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>@lang('Meals')</label><br>
                                            <div class="input-group mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="full_meals" id="fullMeals" value="1" {{ old('full_meals', $weeklyWellnessCheck->full_meals) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="fullMeals">@lang('Full meals')</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="partial_meals" id="partialMeals" value="1" {{ old('partial_meals', $weeklyWellnessCheck->partial_meals) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="partialMeals">@lang('Partial meals')</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox" name="minimal_meals" id="minimalMeals" value="1" {{ old('minimal_meals', $weeklyWellnessCheck->minimal_meals) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="minimalMeals">@lang('Minimal meals')</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="skin_wounds">@lang('Skin and Wounds')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-band-aid"></i></span>
                                                </div>
                                                <textarea name="skin_wounds" id="skin_wounds" class="form-control @error('skin_wounds') is-invalid @enderror" rows="3" placeholder="@lang('Any rashes, dryness, or signs of infection. Healing status of existing wounds.')">{{ old('skin_wounds', $weeklyWellnessCheck->skin_wounds) }}</textarea>
                                                @error('skin_wounds')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>@lang('Mobility')</label><br>
                                            <div class="input-group mb-3">
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="mobility" id="mobilityNormal" value="Normal" {{ old('mobility', $weeklyWellnessCheck->mobility) == 'Normal' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="mobilityNormal">@lang('Normal')</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="radio" name="mobility" id="mobilityLimited" value="Limited" {{ old('mobility', $weeklyWellnessCheck->mobility) == 'Limited' ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="mobilityLimited">@lang('Limited')</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mobility_notes">@lang('Mobility Notes')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-walking"></i></span>
                                                </div>
                                                <textarea name="mobility_notes" id="mobility_notes" class="form-control @error('mobility_notes') is-invalid @enderror" rows="3" placeholder="@lang('Signs of pain or discomfort during activity.')">{{ old('mobility_notes', $weeklyWellnessCheck->mobility_notes) }}</textarea>
                                                @error('mobility_notes')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="sleep">@lang('Sleep')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-bed"></i></span>
                                                </div>
                                                <textarea name="sleep" id="sleep" class="form-control @error('sleep') is-invalid @enderror" rows="3" placeholder="@lang('Patterns or disturbances noted per caregiver.')">{{ old('sleep', $weeklyWellnessCheck->sleep) }}</textarea>
                                                @error('sleep')
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

                        <!-- Emotional and Behavioral Signs Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Emotional and Behavioral Signs')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="mood">@lang('Mood')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-smile"></i></span>
                                                </div>
                                                <textarea name="mood" id="mood" class="form-control @error('mood') is-invalid @enderror" rows="3" placeholder="@lang('Observable signs (e.g., happy, neutral, withdrawn).')">{{ old('mood', $weeklyWellnessCheck->mood) }}</textarea>
                                                @error('mood')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="engagement">@lang('Engagement')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hands-helping"></i></span>
                                                </div>
                                                <textarea name="engagement" id="engagement" class="form-control @error('engagement') is-invalid @enderror" rows="3" placeholder="@lang('Participation in activities: Fully involved, partial, or withdrawn?')">{{ old('engagement', $weeklyWellnessCheck->engagement) }}</textarea>
                                                @error('engagement')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="behavior_changes">@lang('Behavior Changes')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-exclamation-triangle"></i></span>
                                                </div>
                                                <textarea name="behavior_changes" id="behavior_changes" class="form-control @error('behavior_changes') is-invalid @enderror" rows="3" placeholder="@lang('Any unusual behavior (e.g., distress, aggression, avoidance).')">{{ old('behavior_changes', $weeklyWellnessCheck->behavior_changes) }}</textarea>
                                                @error('behavior_changes')
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

                        <!-- Social Interaction Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Social Interaction')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="with_caregivers">@lang('With Caregivers')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-hands"></i></span>
                                                </div>
                                                <textarea name="with_caregivers" id="with_caregivers" class="form-control @error('with_caregivers') is-invalid @enderror" rows="3" placeholder="@lang('Trusting/avoiding.')">{{ old('with_caregivers', $weeklyWellnessCheck->with_caregivers) }}</textarea>
                                                @error('with_caregivers')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="with_peers">@lang('With Peers')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                                </div>
                                                <textarea name="with_peers" id="with_peers" class="form-control @error('with_peers') is-invalid @enderror" rows="3" placeholder="@lang('Interacts, avoids, or shows conflict.')">{{ old('with_peers', $weeklyWellnessCheck->with_peers) }}</textarea>
                                                @error('with_peers')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="communication">@lang('Communication')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-comments"></i></span>
                                                </div>
                                                <textarea name="communication" id="communication" class="form-control @error('communication') is-invalid @enderror" rows="3" placeholder="@lang('Responds to verbal/nonverbal cues appropriately.')">{{ old('communication', $weeklyWellnessCheck->communication) }}</textarea>
                                                @error('communication')
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

                        <!-- Pain and Comfort Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Pain and Comfort')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="pain_indicators">@lang('Pain Indicators')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-frown"></i></span>
                                                </div>
                                                <textarea name="pain_indicators" id="pain_indicators" class="form-control @error('pain_indicators') is-invalid @enderror" rows="3" placeholder="@lang('Grimacing, guarding, or changes in posture.')">{{ old('pain_indicators', $weeklyWellnessCheck->pain_indicators) }}</textarea>
                                                @error('pain_indicators')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="comfort">@lang('Comfort')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-couch"></i></span>
                                                </div>
                                                <textarea name="comfort" id="comfort" class="form-control @error('comfort') is-invalid @enderror" rows="3" placeholder="@lang('Room clean and organized? Any items needed for comfort (toys, blankets)?')">{{ old('comfort', $weeklyWellnessCheck->comfort) }}</textarea>
                                                @error('comfort')
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

                        <!-- Medical and Environmental Review Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Medical and Environmental Review')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="medication">@lang('Medication')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-pills"></i></span>
                                                </div>
                                                <textarea name="medication" id="medication" class="form-control @error('medication') is-invalid @enderror" rows="3" placeholder="@lang('Taken as prescribed? Are there any missed doses?')">{{ old('medication', $weeklyWellnessCheck->medication) }}</textarea>
                                                @error('medication')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="signs_of_illness">@lang('Signs of Illness')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-thermometer-half"></i></span>
                                                </div>
                                                <textarea name="signs_of_illness" id="signs_of_illness" class="form-control @error('signs_of_illness') is-invalid @enderror" rows="3" placeholder="@lang('Fever, cough, infections, or other symptoms.')">{{ old('signs_of_illness', $weeklyWellnessCheck->signs_of_illness) }}</textarea>
                                                @error('signs_of_illness')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="hydration">@lang('Hydration')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-tint"></i></span>
                                                </div>
                                                <textarea name="hydration" id="hydration" class="form-control @error('hydration') is-invalid @enderror" rows="3" placeholder="@lang('Skin turgor, mucous membranes, urine output.')">{{ old('hydration', $weeklyWellnessCheck->hydration) }}</textarea>
                                                @error('hydration')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="environment">@lang('Environment')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-home"></i></span>
                                                </div>
                                                <textarea name="environment" id="environment" class="form-control @error('environment') is-invalid @enderror" rows="3" placeholder="@lang('Safe, clean, and suitable for the child.')">{{ old('environment', $weeklyWellnessCheck->environment) }}</textarea>
                                                @error('environment')
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

                        <!-- Notes and Follow-Up Section -->
                        <div class="card mb-4">
                            <div class="card-header"><h3 class="card-title">@lang('Notes and Follow-Up')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="progress">@lang('Progress')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-chart-line"></i></span>
                                                </div>
                                                <textarea name="progress" id="progress" class="form-control @error('progress') is-invalid @enderror" rows="3" placeholder="@lang('Better, worse, or no change since last week?')">{{ old('progress', $weeklyWellnessCheck->progress) }}</textarea>
                                                @error('progress')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="next_steps">@lang('Next Steps')</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fas fa-shoe-prints"></i></span>
                                                </div>
                                                <textarea name="next_steps" id="next_steps" class="form-control @error('next_steps') is-invalid @enderror" rows="3" placeholder="@lang('Adjustments to care or new actions needed?')">{{ old('next_steps', $weeklyWellnessCheck->next_steps) }}</textarea>
                                                @error('next_steps')
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

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-md-3 col-form-label"></label>
                                    <div class="col-md-8">
                                        <input type="submit" value="{{ __('Submit') }}" class="btn btn-outline btn-info btn-lg"/>
                                        <a href="{{ route('weekly-wellness-checks.index') }}" class="btn btn-outline btn-warning btn-lg">{{ __('Cancel') }}</a>
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
    <script>
        // Initialize vital signs functionality
        $(document).ready(function() {
            // If there's already vital signs data, show it in the container
            const existingVitalSigns = $('#vital_signs').val();
            if (existingVitalSigns) {
                // For now, we'll keep the existing textarea visible if it has data
                $('#vital_signs').show();
                $('#vital-signs-container').hide();
            }
        });
    </script>
@endpush

