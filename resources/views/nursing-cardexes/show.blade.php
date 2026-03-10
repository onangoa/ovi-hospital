@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><a href="{{ route('nursing-cardexes.index') }}" class="btn btn-outline btn-info">
                        <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('nursing-cardexes.index') }}">@lang('Nursing Cardex List')</a></li>
                        <li class="breadcrumb-item active">@lang('Show Nursing Cardex')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Show Nursing Cardex')</h4>
                    <div class="card-tools">
                        <a href="{{ route('nursing-cardexes.show', $nursingCardex) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Patient')</label>
                                <p>{{ $nursingCardex->patient->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Date')</label>
                                <p>{{ $nursingCardex->date->format('d-m-Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label>@lang('Conducted by')</label>
                                <p>{{ $nursingCardex->nurse_on_duty_name }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Vital Signs')</label>
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Temperature:</strong> {{ $nursingCardex->vital_signs['temperature'] ?? 'N/A' }} °C
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Blood Pressure:</strong> {{ $nursingCardex->vital_signs['systolic_bp'] ?? 'N/A' }}/{{ $nursingCardex->vital_signs['diastolic_bp'] ?? 'N/A' }} mmHg
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Pulse Rate:</strong> {{ $nursingCardex->vital_signs['pulse_rate'] ?? 'N/A' }} bpm
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Respiratory Rate:</strong> {{ $nursingCardex->vital_signs['respiratory_rate'] ?? 'N/A' }} /min
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <strong>Oxygen Saturation:</strong> {{ $nursingCardex->vital_signs['oxygen_saturation'] ?? 'N/A' }} %
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <strong>Hb:</strong> {{ $nursingCardex->vital_signs['hb'] ?? 'N/A' }} g/dL
                                    </div>
                                    <div class="col-md-3">
                                        <strong>RBS:</strong> {{ $nursingCardex->vital_signs['rbs'] ?? 'N/A' }} mg/dL
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Brief report')</label>
                                <p>{{ $nursingCardex->brief_report }}</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
