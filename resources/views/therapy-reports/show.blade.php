@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('therapy-reports.index') }}">@lang('Therapy Reports')</a></li>
                        <li class="breadcrumb-item active">@lang('Therapy Report Info')</li>
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
                        @if(!empty($therapyReport->patient_name))
                            @lang('Individual Therapy Report Info')
                        @else
                            @lang('Group Therapy Report Info')
                        @endif
                    </h3>
                    @can('therapy-reports-update')
                        <div class="card-tools">
                            @if(!empty($therapyReport->patient_name))
                                <a href="{{ route('individual-therapy.edit', $therapyReport) }}" class="btn btn-info">@lang('Edit Individual Therapy')</a>
                                <a href="{{ route('individual-therapy.show', $therapyReport) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                                </a>
                            @else
                                <a href="{{ route('group-therapy.edit', $therapyReport) }}" class="btn btn-info">@lang('Edit Group Therapy')</a>
                                <a href="{{ route('group-therapy.show', $therapyReport) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                    <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                                </a>
                            @endif
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    @if(!empty($therapyReport->patient_name))
                        {{-- Individual Therapy Session --}}
                        
                        <div class="row">
                            <div class="col-md-3 text-center">
                                <div class="card card-primary card-outline">
                                    <div class="card-body box-profile">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ $therapyReport->patient->photo_url ?? asset('assets/images/profile/default.jpg') }}" alt="User profile picture">
                                        <h3 class="profile-username text-center">{{ $therapyReport->patient_name ?? 'N/A' }}</h3>
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
                                                    <label for="physiotherapist_signature">@lang('Conducted by')</label>
                                                    <p>{{ $therapyReport->physiotherapist_signature ?? 'N/A' }}</p>
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
                    @else
                        {{-- Group Therapy Session --}}
                        
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
                                            <label for="physiotherapist_signature">@lang('Conducted by')</label>
                                            <p>{{ $therapyReport->physiotherapist_signature ?? 'N/A' }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-3">
                            <div class="card-header">
                                <h3 class="card-title">@lang('Group Therapy Session')</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="group_participants">@lang('Participants')</label>
                                    <div class="alert alert-info">
                                        <i class="fas fa-users"></i> {{ $therapyReport->group_participants ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="group_session_summary">@lang('Session Summary')</label>
                                    <p>{{ $therapyReport->group_session_summary ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    @if(empty($therapyReport->patient_name))
                    {{-- Only show End-of-Day Notes for Group Therapy --}}
                    <div class="card mb-4">
                        <div class="card-header"><h3 class="card-title">@lang('End-of-Day Notes & Clean-Up')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="overall_observations">@lang('Overall Observations')</label>
                                <p>{{ $therapyReport->overall_observations ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="equipment_clean_up">@lang('Equipment/Room Clean-Up')</label>
                                <p>{{ $therapyReport->equipment_clean_up ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="additional_comments">@lang('Additional Comments')</label>
                                <p>{{ $therapyReport->additional_comments ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
