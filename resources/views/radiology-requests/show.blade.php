@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3><a href="{{ route('radiology-requests.index') }}" class="btn btn-outline btn-info">
                        <i class="fa fa-arrow-left"></i> @lang('Back')
                        </a>
                    </h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('radiology-requests.index') }}">@lang('Radiology Request List')</a></li>
                        <li class="breadcrumb-item active">@lang('Show Radiology Request')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">@lang('Show Radiology Request')</h4>
                    <div class="card-tools">
                        <a href="{{ route('radiology-requests.show', $radiologyRequest) }}?export_pdf=1" class="btn btn-danger" target="_blank">
                            <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Patient')</label>
                                <p>{{ $radiologyRequest->patient->name }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>@lang('Blood Group')</label>
                                <p>{{ $radiologyRequest->patient->blood_group }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Conducted by</label>
                                <p>
                                    @if($radiologyRequest->provider_id)
                                        {{ App\Models\User::find($radiologyRequest->provider_id)->name ?? 'User ID: ' . $radiologyRequest->provider_id . ' (Not Found)' }}
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Examination Requested')</label>
                                <p>{{ implode(', ', $radiologyRequest->examination_type ?? []) }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Examination Details (including body organs to be imaged)')</label>
                                <p>{{ $radiologyRequest->examination_details }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Relevant Clinical Information')</label>
                                <p>{{ $radiologyRequest->relevant_clinical_information }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>@lang('Reason for Radiological Investigation')</label>
                                <p>{{ $radiologyRequest->reason_for_investigation }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
