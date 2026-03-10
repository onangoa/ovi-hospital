@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('therapy-reports.individual') }}">@lang('Individual Therapy Reports')</a></li>
                        <li class="breadcrumb-item active">@lang('Individual Therapy Report Info')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-user-injured"></i> @lang('Individual Therapy Report Info')
                    </h3>
                    @can('therapy-reports-update')
                        <div class="card-tools">
                            <a href="{{ route('individual-therapy.edit', $therapyReport) }}" class="btn btn-primary">@lang('Edit Individual Therapy')</a>
                            <a href="{{ route('individual-therapy.show', $therapyReport) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-3 text-center">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <img class="profile-user-img img-fluid img-circle" src="{{ $therapyReport->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}" alt="User profile picture">
                                    <h3 class="profile-username text-center">{{ $therapyReport->patient->name ?? 'N/A' }}</h3>
                                    <p class="text-muted text-center">@lang('Patient')</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('Session Details')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="date">@lang('Date')</label>
                                                <p>{{ \Carbon\Carbon::parse($therapyReport->date)->format('d-m-Y') ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="physiotherapist">@lang('Conducted by')</label>
                                                <p>{{ $therapyReport->physiotherapist->name ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="session_time">@lang('Session Time')</label>
                                                <p>{{ $therapyReport->session_time ?? 'N/A' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="card mt-3">
                                <div class="card-header">
                                    <h3 class="card-title">@lang('Individual Therapy Session')</h3>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="session_summary">@lang('Session Summary')</label>
                                        <p>{{ $therapyReport->session_summary ?? 'N/A' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection