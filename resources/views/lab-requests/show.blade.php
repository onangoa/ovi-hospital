@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('lab-requests.index') }}">@lang('Lab Request')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Lab Request Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Lab Request Info')</h3>
                    @can('lab-requests-update')
                        <div class="card-tools">
                            <a href="{{ route('lab-requests.edit', $labRequest) }}" class="btn btn-primary">@lang('Edit')</a>
                            <a href="{{ route('lab-requests.show', $labRequest) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    {{-- Patient Info --}}
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                 src="{{ $labRequest->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}"
                                 alt="User profile picture">
                            <h3 class="profile-username text-center">
                                {{ $labRequest->patient->name ?? 'N/A' }}
                            </h3>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('Age')</label>
                                        <p>{{ $labRequest->patient->age ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('Sex')</label>
                                        <p>{{ $labRequest->patient->gender ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('Blood Group')</label>
                                        <p>{{ $labRequest->patient->blood_group ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('Resident/Village')</label>
                                        <p>{{ $labRequest->patient->address ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('Conducted by')</label>
                                        <p>{{ $labRequest->clinician_name ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>@lang('Request Date')</label>
                                        <p>{{ $labRequest->request_date ? date($companySettings->date_format, strtotime($labRequest->request_date)) : 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Specimen --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Specimen')</h3>
                        </div>
                        <div class="card-body">
                            <p>{{ $labRequest->specimen ?? 'N/A' }}</p>
                        </div>
                    </div>

                    {{-- Vital Signs --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Vital Signs')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Temperature (°C)')</label>
                                        <p>{{ $labRequest->vital_signs['temperature'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Pulse Rate (bpm)')</label>
                                        <p>{{ $labRequest->vital_signs['pulse_rate'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Systolic BP (mmHg)')</label>
                                        <p>{{ $labRequest->vital_signs['systolic_bp'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Diastolic BP (mmHg)')</label>
                                        <p>{{ $labRequest->vital_signs['diastolic_bp'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('SpO2 (%)')</label>
                                        <p>{{ $labRequest->vital_signs['oxygen_saturation'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Pain Score (0-10)')</label>
                                        <p>{{ $labRequest->vital_signs['pain_score'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('Hb (g/dL)')</label>
                                        <p>{{ $labRequest->vital_signs['hb'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label>@lang('RBS (mg/dL)')</label>
                                        <p>{{ $labRequest->vital_signs['rbs'] ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Specimen Destination --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Specimen Destination')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>@lang('Blood Bank')</label>
                                    <p>{{ $labRequest->blood_bank ? __('Yes') : __('No') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Histology/Cytology')</label>
                                    <p>{{ $labRequest->histology ? __('Yes') : __('No') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Serology')</label>
                                    <p>{{ $labRequest->serology ? __('Yes') : __('No') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Haematology')</label>
                                    <p>{{ $labRequest->haematology ? __('Yes') : __('No') }}</p>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-3">
                                    <label>@lang('Bacteriology')</label>
                                    <p>{{ $labRequest->bacteriology ? __('Yes') : __('No') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Parasitology')</label>
                                    <p>{{ $labRequest->parasitology ? __('Yes') : __('No') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Biochemistry')</label>
                                    <p>{{ $labRequest->biochemistry ? __('Yes') : __('No') }}</p>
                                </div>
                                <div class="col-md-3">
                                    <label>@lang('Other')</label>
                                    <p>{{ $labRequest->other_destination ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Investigation & Diagnosis --}}
                    <div class="card mb-4">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Investigation and Diagnosis')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>@lang('Investigation Requested')</label>
                                <p>{{ $labRequest->investigation_requested ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label>@lang('Differential Diagnosis')</label>
                                <p>{{ $labRequest->differential_diagnosis ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div>
    </div>
@endsection
