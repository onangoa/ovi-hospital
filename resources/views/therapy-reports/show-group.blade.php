@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('therapy-reports.group') }}">@lang('Group Therapy Reports')</a></li>
                        <li class="breadcrumb-item active">@lang('Group Therapy Report Info')</li>
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
                        <i class="fas fa-users"></i> @lang('Group Therapy Report Info')
                    </h3>
                    @can('therapy-reports-update')
                        <div class="card-tools">
                            <a href="{{ route('group-therapy.edit', $therapyReport) }}" class="btn btn-primary">@lang('Edit Group Therapy')</a>
                            <a href="{{ route('group-therapy.show', $therapyReport) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                                <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                            </a>
                        </div>
                    @endcan
                </div>
                <div class="card-body">
                    
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
                        </div>
                    </div>
                    
                    <div class="card mt-3">
                        <div class="card-header">
                            <h3 class="card-title">@lang('Group Therapy Session')</h3>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="participant_ids">@lang('Participants')</label>
                                <div class="alert alert-info">
                                    <i class="fas fa-users"></i>
                                    @if($therapyReport->participant_ids && count($therapyReport->participant_ids) > 0)
                                        @foreach($therapyReport->participant_ids as $participantId)
                                            {{ App\Models\User::find($participantId)->name ?? 'N/A' }}@if(!$loop->last), @endif
                                        @endforeach
                                    @else
                                        N/A
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="ward_id">@lang('Ward')</label>
                                <p>{{ $therapyReport->ward->name ?? 'N/A' }}</p>
                            </div>
                            <div class="form-group">
                                <label for="group_session_summary">@lang('Session Summary')</label>
                                <p>{{ $therapyReport->group_session_summary ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- End-of-Day Notes & Clean-Up Section --}}
                    <div class="card mt-3">
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
                </div>
            </div>
        </div>
    </div>
@endsection