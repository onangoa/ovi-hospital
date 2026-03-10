@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('caregiver-daily-reports-create')
                        <h3>
                            <a href="{{ route('caregiver-daily-reports.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Caregiver Daily Report')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Caregiver Daily Report List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Caregiver Daily Report List')</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <a class="btn btn-primary" target="_blank" href="{{ route('caregiver-daily-reports.index') }}?export=1">
                                <i class="fas fa-file-excel"></i> @lang('Export CSV')
                            </a>
                            <a class="btn btn-danger" target="_blank" href="{{ route('caregiver-daily-reports.index') }}?export_pdf=1">
                                <i class="fas fa-file-pdf"></i> @lang('Export PDF')
                            </a>
                        </div>
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
                                            <label>@lang('Date')</label>
                                            <input type="text" name="date" class="form-control" value="{{ request()->date }}" placeholder="@lang('Date')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Conducted by')</label>
                                            <input type="text" name="caregiver_name" class="form-control" value="{{ request()->caregiver_name }}" placeholder="@lang('Conducted by')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('caregiver-daily-reports.index') }}" class="btn btn-secondary">@lang('Clear')</a>
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
                                <th>@lang('Date')</th>
                                <th>@lang('Conducted by')</th>
                                <th>@lang('Mood')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr>
                                    <td>{{ $report->patient->name ?? 'N/A' }}</td>
                                    <td>{{ $report->date }}</td>
                                    <td>{{ optional($report->caregiver)->name }}</td>

                                    <td>{{ $report->mood ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('caregiver-daily-reports.show', $report) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('caregiver-daily-reports-update')
                                                <a href="{{ route('caregiver-daily-reports.edit', $report) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('caregiver-daily-reports-delete')
                                                <a href="#" data-href="{{ route('caregiver-daily-reports.destroy', $report) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $reports->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
