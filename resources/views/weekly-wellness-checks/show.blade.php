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
                        <li class="breadcrumb-item active">@lang('Weekly Wellness Check Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Weekly Wellness Check Info')</h3>
                    @can('weekly-wellness-checks-update')
                        <div class="card-tools">
                            <a href="{{ route('weekly-wellness-checks.edit', $weeklyWellnessCheck) }}" class="btn btn-primary">@lang('Edit')</a>
                            <a href="{{ route('weekly-wellness-checks.show', $weeklyWellnessCheck) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ $weeklyWellnessCheck->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $weeklyWellnessCheck->patient->name ?? 'N/A' }}</h3>

                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">@lang('Date')</label>
                                        <p>{{ optional($weeklyWellnessCheck->date)->format('Y-m-d') ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="conducted_by">@lang('Conducted By')</label>
                                        <p>{{ $weeklyWellnessCheck->conductedBy->name ?? 'N/A' }}</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Physical Health')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="vital_signs">@lang('Vital Signs')</label>
                                <p>
                                    @if(is_array($weeklyWellnessCheck->vital_signs))
                                        @foreach($weeklyWellnessCheck->vital_signs as $key => $value)
                                            {{ ucfirst(str_replace('_', ' ', $key)) }}: {{ $value }}<br>
                                        @endforeach
                                    @else
                                        {{ $weeklyWellnessCheck->vital_signs ?? 'N/A' }}
                                    @endif
                                </p>
                            </div>
                            <div class="form-group">
                                <label>@lang('Meals')</label>
                                <p>
                                    @if($weeklyWellnessCheck->full_meals)
                                        @lang('Full meals')
                                    @elseif($weeklyWellnessCheck->partial_meals)
                                        @lang('Partial meals')
                                    @elseif($weeklyWellnessCheck->minimal_meals)
                                        @lang('Minimal meals')
                                    @else
                                        @lang('N/A')
                                    @endif
                                </p>
                            </div>
                            <div class="form-group">
                                <label for="skin_wounds">@lang('Skin and Wounds')</label>
                                <p>{{ $weeklyWellnessCheck->skin_wounds ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="mobility">@lang('Mobility')</label>
                                <p>{{ $weeklyWellnessCheck->mobility ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="mobility_notes">@lang('Mobility Notes')</label>
                                <p>{{ $weeklyWellnessCheck->mobility_notes ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="sleep">@lang('Sleep')</label>
                                <p>{{ $weeklyWellnessCheck->sleep ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Emotional and Behavioral Signs')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="mood">@lang('Mood')</label>
                                <p>{{ $weeklyWellnessCheck->mood ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="engagement">@lang('Engagement')</label>
                                <p>{{ $weeklyWellnessCheck->engagement ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="behavior_changes">@lang('Behavior Changes')</label>
                                <p>{{ $weeklyWellnessCheck->behavior_changes ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Social Interaction')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="with_caregivers">@lang('With Caregivers')</label>
                                <p>{{ $weeklyWellnessCheck->with_caregivers ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="with_peers">@lang('With Peers')</label>
                                <p>{{ $weeklyWellnessCheck->with_peers ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="communication">@lang('Communication')</label>
                                <p>{{ $weeklyWellnessCheck->communication ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Pain and Comfort')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="pain_indicators">@lang('Pain Indicators')</label>
                                <p>{{ $weeklyWellnessCheck->pain_indicators ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="comfort">@lang('Comfort')</label>
                                <p>{{ $weeklyWellnessCheck->comfort ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Medical and Environmental Review')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="medication">@lang('Medication')</label>
                                <p>{{ $weeklyWellnessCheck->medication ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="signs_of_illness">@lang('Signs of Illness')</label>
                                <p>{{ $weeklyWellnessCheck->signs_of_illness ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="hydration">@lang('Hydration')</label>
                                <p>{{ $weeklyWellnessCheck->hydration ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="environment">@lang('Environment')</label>
                                <p>{{ $weeklyWellnessCheck->environment ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">

                        <div class="card-header"><h3 class="card-title">@lang('Notes and Follow-Up')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="progress">@lang('Progress')</label>
                                <p>{{ $weeklyWellnessCheck->progress ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="next_steps">@lang('Next Steps')</label>
                                <p>{{ $weeklyWellnessCheck->next_steps ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
