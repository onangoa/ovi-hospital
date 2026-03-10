@extends('layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('patient-details.index') }}">@lang('Patients')</a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Patient Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Patient Info Card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">@lang('Patient Info')</h3>
            <div class="card-tools">
                <a href="{{ route('patient-details.show', $patientDetail) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                    <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                </a>
                @can('patient-detail-update')
                    <a href="{{ route('patient-details.edit', $patientDetail) }}" class="btn btn-primary">@lang('Edit')</a>
                @endcan
            </div>
        </div>
        <div class="card-body">

            <!-- Profile + Main Details -->
            <div class="row align-items-center">
                <!-- Left Column: Profile -->
                <div class="col-md-3 text-center mb-3">
                    <img class="profile-user-img img-fluid img-circle mb-2"
                         src="{{ $patientDetail->photo_url }}"
                         alt="User profile picture">
                    <h3 class="profile-username">{{ $patientDetail->name }}</h3>
                </div>

                <!-- Right Column: Details -->
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-3">
                            <label>@lang('Email')</label>
                            <p>{{ $patientDetail->email }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Phone')</label>
                            <p>{{ $patientDetail->phone }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Gender')</label>
                            <p>{{ ucfirst($patientDetail->gender) }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Blood Group')</label>
                            <p>{{ $patientDetail->blood_group }}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>@lang('Date of Birth')</label>
                            <p>{{ $patientDetail->date_of_birth }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Status')</label>
                            <p>
                                @if($patientDetail->status == 1)
                                    <span class="badge badge-pill badge-success">@lang('Active')</span>
                                @else
                                    <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Age')</label>
                            <p>{{ $patientDetail->age }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Address')</label>
                            <p>{!! $patientDetail->address !!}</p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label>@lang('Weight (kg)')</label>
                            <p>{{ $patientDetail->weight ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Height (cm)')</label>
                            <p>{{ $patientDetail->height ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('CVI Score')</label>
                            <p>{{ $patientDetail->cviScores->sortByDesc('date')->first()->score ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-3">
                            <label>@lang('Ward Assigned')</label>
                            <p>{{ $patientDetail->wards->first()->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Guardian & Care Preferences Side by Side -->
            <div class="row mt-4">
                <!-- Guardian Card -->
                <div class="col-md-6">
                    <div class="card h-100">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Parent/Guardian Details')</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>@lang('Name')</label>
                                    <p>{{ $patientDetail->guardian_name }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label>@lang('Phone')</label>
                                    <p>{{ $patientDetail->guardian_phone }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label>@lang('Email')</label>
                                    <p>{{ $patientDetail->guardian_email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <label>@lang('Relation')</label>
                                    <p>{{ $patientDetail->guardian_relation }}</p>
                                </div>
                                <div class="col-md-12">
                                    <label>@lang('Address')</label>
                                    <p>{!! nl2br(e($patientDetail->guardian_address)) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Care Preferences Card -->
                <div class="col-md-6">
                    @if($patientDetail->carePreferences)
                        <div class="card h-100">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Care Preferences')</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>@lang('Likes')</label>
                                        <p>{!! nl2br(e($patientDetail->carePreferences->likes)) !!}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>@lang('Dislikes')</label>
                                        <p>{!! nl2br(e($patientDetail->carePreferences->dislikes)) !!}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>@lang('Care Preferences')</label>
                                        <p>{!! nl2br(e($patientDetail->carePreferences->care_preferences)) !!}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <label>@lang('Additional Info')</label>
                                        <p>{!! nl2br(e($patientDetail->carePreferences->info)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Clinical Reports Tabs -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Clinical Reports')</h3>
                        </div>
                        <div class="card-body">
                            <ul class="nav nav-tabs" id="clinicalReportsTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="medical-referrals-tab" data-toggle="tab" href="#medical-referrals" role="tab" aria-controls="medical-referrals" aria-selected="true">@lang('Medical Referrals')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="radiology-requests-tab" data-toggle="tab" href="#radiology-requests" role="tab" aria-controls="radiology-requests" aria-selected="false">@lang('Radiology Requests')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="care-plans-tab" data-toggle="tab" href="#care-plans" role="tab" aria-controls="care-plans" aria-selected="false">@lang('Care Plans')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="ward-round-notes-tab" data-toggle="tab" href="#ward-round-notes" role="tab" aria-controls="ward-round-notes" aria-selected="false">@lang('Ward Round Notes')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="therapy-reports-tab" data-toggle="tab" href="#therapy-reports" role="tab" aria-controls="therapy-reports" aria-selected="false">@lang('Therapy Reports')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="cvi-scores-tab" data-toggle="tab" href="#cvi-scores" role="tab" aria-controls="cvi-scores" aria-selected="false">@lang('CVI Scores')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="caregiver-daily-reports-tab" data-toggle="tab" href="#caregiver-daily-reports" role="tab" aria-controls="caregiver-daily-reports" aria-selected="false">@lang('Caregiver Daily Reports')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="lab-reports-tab" data-toggle="tab" href="#lab-reports" role="tab" aria-controls="lab-reports" aria-selected="false">@lang('Lab Reports')</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="lab-requests-tab" data-toggle="tab" href="#lab-requests" role="tab" aria-controls="lab-requests" aria-selected="false">@lang('Lab Requests')</a>
                                </li>
                            </ul>
                            <div class="tab-content" id="clinicalReportsTabContent">
                                <div class="tab-pane fade show active" id="medical-referrals" role="tabpanel" aria-labelledby="medical-referrals-tab">
                                    @include('patient-detail.tabs.medical-referrals', ['medicalReferrals' => $patientDetail->medicalReferrals])
                                </div>
                                <div class="tab-pane fade" id="radiology-requests" role="tabpanel" aria-labelledby="radiology-requests-tab">
                                    @include('patient-detail.tabs.radiology-requests', ['radiologyRequests' => $patientDetail->radiologyRequests])
                                </div>
                                <div class="tab-pane fade" id="care-plans" role="tabpanel" aria-labelledby="care-plans-tab">
                                    @include('patient-detail.tabs.care-plans', ['carePlans' => $patientDetail->carePlans])
                                </div>
                                <div class="tab-pane fade" id="ward-round-notes" role="tabpanel" aria-labelledby="ward-round-notes-tab">
                                    @include('patient-detail.tabs.ward-round-notes', ['wardRoundNotes' => $patientDetail->wardRoundNotes])
                                </div>
                                <div class="tab-pane fade" id="therapy-reports" role="tabpanel" aria-labelledby="therapy-reports-tab">
                                    @include('patient-detail.tabs.therapy-reports', ['therapyReports' => $patientDetail->therapyReports])
                                </div>
                                <div class="tab-pane fade" id="cvi-scores" role="tabpanel" aria-labelledby="cvi-scores-tab">
                                    @include('patient-detail.tabs.cvi-scores', ['cviScores' => $patientDetail->cviScores])
                                </div>
                                <div class="tab-pane fade" id="caregiver-daily-reports" role="tabpanel" aria-labelledby="caregiver-daily-reports-tab">
                                    @include('patient-detail.tabs.caregiver-daily-reports', ['caregiverDailyReports' => $patientDetail->caregiverDailyReports])
                                </div>
                                <div class="tab-pane fade" id="lab-reports" role="tabpanel" aria-labelledby="lab-reports-tab">
                                    @include('patient-detail.tabs.lab-reports', ['labReports' => $patientDetail->labReports])
                                </div>
                                <div class="tab-pane fade" id="lab-requests" role="tabpanel" aria-labelledby="lab-requests-tab">
                                    @include('patient-detail.tabs.lab-requests', ['labRequests' => $patientDetail->labRequests])
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
