@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('therapy-reports-create')
                        <h3>
                            <a href="{{ route('individual-therapy.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Individual Therapy Report')
                            </a>
                            <a href="{{ route('group-therapy.create') }}" class="btn btn-outline btn-success">
                                + @lang('Add Group Therapy Report')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Therapy Report List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Therapy Report List')</h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" target="_blank" href="{{ route('therapy-reports.index') }}?export=1">
                            <i class="fas fa-cloud-download-alt"></i> @lang('Export')
                        </a>
                        <a class="btn btn-danger" target="_blank" href="{{ route('therapy-reports.index') }}?export_pdf=1">
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
                                            <label>@lang('Date')</label>
                                            <input type="text" name="date" class="form-control" value="{{ request()->date }}" placeholder="@lang('Date')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Patient Name')</label>
                                            <input type="text" name="patient_name" class="form-control" value="{{ request()->patient_name }}" placeholder="@lang('Patient Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Physiotherapist Signature')</label>
                                            <input type="text" name="physiotherapist_signature" class="form-control" value="{{ request()->physiotherapist_signature }}" placeholder="@lang('Physiotherapist Signature')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('therapy-reports.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Date')</th>
                                <th>@lang('Patient Name')</th>
                                <th>@lang('Session Time')</th>
                                <th>@lang('Physiotherapist Signature')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($therapyReports as $therapyReport)
                                <tr>
                                    <td>{{ $therapyReport->date }}</td>
                                    <td>{{ $therapyReport->patient_name }}</td>
                                    <td>{{ $therapyReport->session_time }}</td>
                                    <td>{{ $therapyReport->physiotherapist_signature }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('therapy-reports.show', $therapyReport) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('therapy-reports-update')
                                                @if(!empty($therapyReport->patient_name))
                                                    <a href="{{ route('individual-therapy.edit', $therapyReport) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit Individual Therapy')"><i class="fa fa-user ambitious-padding-btn"></i></a>
                                                @else
                                                    <a href="{{ route('group-therapy.edit', $therapyReport) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit Group Therapy')"><i class="fa fa-users ambitious-padding-btn"></i></a>
                                                @endif
                                            @endcan
                                            @can('therapy-reports-delete')
                                                <a href="#" data-href="{{ route('therapy-reports.destroy', $therapyReport) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $therapyReports->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection