@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('lab-requests-create')
                        <h3>
                            <a href="{{ route('lab-requests.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Lab Request')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Lab Request List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Lab Request List')</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" target="_blank" href="{{ route('lab-requests.index') }}?export=1">
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <a class="btn btn-danger" target="_blank" href="{{ route('lab-requests.index') }}?export_pdf=1">
                            <i class="fas fa-file-pdf"></i> @lang('PDF Export')
                        </a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter">
                            <i class="fas fa-filter"></i> @lang('Filter')
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if(request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Patient Name')</label>
                                            <input type="text" name="patient_name" class="form-control" value="{{ request()->patient_name }}" placeholder="@lang('Patient Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Conducted by')</label>
                                            <input type="text" name="clinician_name" class="form-control" value="{{ request()->clinician_name }}" placeholder="@lang('Conducted by')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Request Date')</label>
                                            <input type="text" name="request_date" class="form-control" value="{{ request()->request_date }}" placeholder="@lang('Request Date')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('lab-requests.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Patient Name')</th>
                                <th>@lang('Age')</th>
                                <th>@lang('Sex')</th>
                                <th>@lang('Specimen')</th>
                                <th>@lang('Conducted by')</th>
                                <th>@lang('Request Date')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($labRequests as $labRequest)
                                <tr>
                                    <td>{{ $labRequest->patient->name ?? '' }}</td>

                                    <td>{{ $labRequest->patient->age ?? '' }}</td>
                                    <td>{{ $labRequest->patient->gender ?? '' }}</td>
                                    <td>{{ Str::limit($labRequest->specimen ?? '', 50) }}</td>
                                    <td>{{ $labRequest->clinician->name ?? $labRequest->clinician_name }}</td>
                                    <td>{{ optional($labRequest->request_date)->format('Y-m-d') }}</td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('lab-requests.show', $labRequest) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('lab-requests-update')
                                                <a href="{{ route('lab-requests.edit', $labRequest) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('lab-requests-delete')
                                                <a href="#" data-href="{{ route('lab-requests.destroy', $labRequest) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $labRequests->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
