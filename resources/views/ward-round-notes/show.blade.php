@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('ward-round-notes.index') }}">@lang('Ward Round Notes')</a></li>
                        <li class="breadcrumb-item active">@lang('Ward Round Note Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Ward Round Note Info')</h3>
                    @can('ward-round-notes-update')
                        <div class="card-tools">
                            <a href="{{ route('ward-round-notes.edit', $wardRoundNote) }}" class="btn btn-primary">@lang('Edit')</a>
                            <a href="{{ route('ward-round-notes.show', $wardRoundNote) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ $wardRoundNote->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}" alt="User profile picture">
                            <h3 class="profile-username text-center">{{ $wardRoundNote->patient->name ?? 'N/A' }}</h3>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="date">@lang('Date')</label>
                                        <p>{{ optional($wardRoundNote->date)->format('Y-m-d') ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="attending_clinician">@lang('Conducted by')</label>
                                        <p>{{ $wardRoundNote->attendingClinician->name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Vital Signs')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="temperature">@lang('Temperature (°C)')</label>
                                        <p>{{ $wardRoundNote->vital_signs['temperature'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="pulse_rate">@lang('Pulse Rate (bpm)')</label>
                                        <p>{{ $wardRoundNote->vital_signs['pulse_rate'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="respiratory_rate">@lang('Respiratory Rate')</label>
                                        <p>{{ $wardRoundNote->vital_signs['respiratory_rate'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="oxygen_saturation">@lang('SpO2 (%)')</label>
                                        <p>{{ $wardRoundNote->vital_signs['oxygen_saturation'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="systolic_bp">@lang('Systolic BP (mmHg)')</label>
                                        <p>{{ $wardRoundNote->vital_signs['systolic_bp'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="diastolic_bp">@lang('Diastolic BP (mmHg)')</label>
                                        <p>{{ $wardRoundNote->vital_signs['diastolic_bp'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="hb">@lang('Hb (g/dL)')</label>
                                        <p>{{ $wardRoundNote->vital_signs['hb'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="rbs">@lang('RBS (mg/dL)')</label>
                                        <p>{{ $wardRoundNote->vital_signs['rbs'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Assessment Details')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="main_complaints">@lang('Main Complaints')</label>
                                <p>{{ $wardRoundNote->main_complaints ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="examination_findings">@lang('Examination Findings')</label>
                                <p>{{ $wardRoundNote->examination_findings ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Systemic Assessment')</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>@lang('System')</th>
                                            <th>@lang('Status')</th>
                                            <th>@lang('Comments')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>@lang('Respiratory')</td>
                                            <td>{{ ucfirst($wardRoundNote->respiratory_status ?? 'N/A') }}</td>
                                            <td>{{ $wardRoundNote->respiratory_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Cardiovascular')</td>
                                            <td>{{ ucfirst($wardRoundNote->cardiovascular_status ?? 'N/A') }}</td>
                                            <td>{{ $wardRoundNote->cardiovascular_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Neurological')</td>
                                            <td>{{ ucfirst($wardRoundNote->neurological_status ?? 'N/A') }}</td>
                                            <td>{{ $wardRoundNote->neurological_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Gastrointestinal')</td>
                                            <td>{{ ucfirst($wardRoundNote->gastrointestinal_status ?? 'N/A') }}</td>
                                            <td>{{ $wardRoundNote->gastrointestinal_comments ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td>@lang('Skin/Wounds')</td>
                                            <td>{{ ucfirst($wardRoundNote->skin_status ?? 'N/A') }}</td>
                                            <td>{{ $wardRoundNote->skin_comments ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('Plan and Updates')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="medications_changes">@lang('Medications/Changes')</label>
                                <p>{{ $wardRoundNote->medications_changes ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="procedures_interventions">@lang('Procedures/Interventions')</label>
                                <p>{{ $wardRoundNote->procedures_interventions ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="pending_tests">@lang('Pending Tests')</label>
                                <p>{{ $wardRoundNote->pending_tests ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">

                        <div class="card-header"><h3 class="card-title">@lang('Progress and Next Steps')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="condition">@lang('Condition')</label>
                                <p>{{ ucfirst($wardRoundNote->condition ?? 'N/A') }}</p>
                            </div>
                            <div class="form-group">
                                <label for="next_steps">@lang('Next Steps')</label>
                                <p>{{ $wardRoundNote->next_steps ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="signature">@lang('Signature')</label>
                                <p>{{ $wardRoundNote->signature ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
