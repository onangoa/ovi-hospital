@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><a href="{{ route('medical-referrals.index') }}" class="btn btn-outline btn-info">
                        <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('medical-referrals.index') }}">@lang('Medical Referral List')</a></li>
                        <li class="breadcrumb-item active">@lang('Show Medical Referral')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Show Medical Referral')</h4>
                    <div class="card-tools">
                        <a href="{{ route('medical-referrals.show', $medicalReferral) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Patient')</label>
                                <p>{{ $medicalReferral->patient->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Conducted by')</label>
                                <p>{{ $medicalReferral->referringDoctor->name ?? 'N/A' }}</p>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Reason for referral')</label>
                                <p>{{ $medicalReferral->reason_for_referral }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Chief complaint')</label>
                                <p>{{ $medicalReferral->chief_complaint }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Patient Brief history')</label>
                                <p>{{ $medicalReferral->patient_brief_history }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Vital Signs')</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Temperature:</strong> {{ $medicalReferral->vital_signs['temperature'] ?? 'N/A' }} °C
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Blood Pressure:</strong> {{ $medicalReferral->vital_signs['systolic_bp'] ?? 'N/A' }}/{{ $medicalReferral->vital_signs['diastolic_bp'] ?? 'N/A' }} mmHg
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Pulse Rate:</strong> {{ $medicalReferral->vital_signs['pulse_rate'] ?? 'N/A' }} bpm
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Respiratory Rate:</strong> {{ $medicalReferral->vital_signs['respiratory_rate'] ?? 'N/A' }} /min
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <strong>Oxygen Saturation:</strong> {{ $medicalReferral->vital_signs['oxygen_saturation'] ?? 'N/A' }} %
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <strong>Hb:</strong> {{ $medicalReferral->vital_signs['hb'] ?? 'N/A' }} g/dL
                                    </div>
                                    <div class="col-md-3">
                                        <strong>RBS:</strong> {{ $medicalReferral->vital_signs['rbs'] ?? 'N/A' }} mg/dL
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Lab investigation done before referral')</label>
                                <p>{{ $medicalReferral->lab_investigation_done }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Treatment done before referral')</label>
                                <p>{{ $medicalReferral->treatment_done }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
