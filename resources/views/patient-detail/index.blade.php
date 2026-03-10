@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('patient-detail-create')
                        <h3><a href="{{ route('patient-details.create') }}" class="btn btn-outline btn-info">+ @lang('Add Patient')</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Patient List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Patient List') </h3>
                    <div class="card-tools">
                        <a class="btn btn-primary" target="_blank" href="{{ route('patient-details.index') }}?export=1"><i class="fas fa-cloud-download-alt"></i> @lang('Export')</a>
                        <a class="btn btn-danger" target="_blank" href="{{ route('patient-details.index') }}?export_pdf=1"><i class="fas fa-file-pdf"></i> @lang('PDF Export')</a>
                        <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i> @lang('Filter')</button>
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
                                            <label>@lang('Name')</label>
                                            <input type="text" name="name" class="form-control" value="{{ request()->name }}" placeholder="@lang('Name')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Weight (kg)')</label>
                                            <input type="text" name="weight" class="form-control" value="{{ request()->weight }}" placeholder="@lang('Weight')">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Height (cm)')</label>
                                            <input type="text" name="height" class="form-control" value="{{ request()->height }}" placeholder="@lang('Height')">
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('patient-details.index') }}" class="btn btn-secondary">@lang('Clear')</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>@lang('Name')</th>
                                <th>@lang('Weight (kg)')</th>
                                <th>@lang('Height (cm)')</th>
                                <th>@lang('Age')</th>
                                <th>@lang('CVI Score')</th>
                                <th>@lang('Ward Assigned')</th>
                                <th>@lang('Status')</th>

                                <th>@lang('Actions')</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($patientDetails as $patientDetail)
                                <tr>
                                    <td>{{ $patientDetail->name }}</td>
                                    <td>{{ $patientDetail->weight ?? 'N/A' }}</td>
                                    <td>{{ $patientDetail->height ?? 'N/A' }}</td>
                                    <td>{{ $patientDetail->age }}</td>
                                    <td>{{ $patientDetail->cviScores->sortByDesc('date')->first()->score ?? 'N/A' }}</td>
                                    <td>{{ $patientDetail->wards->first()->name ?? 'N/A' }}</td>

                                    <td>
                                        @if($patientDetail->status == 1)
                                            <span class="badge badge-pill badge-success">@lang('Active')</span>
                                        @else
                                            <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('patient-details.show', $patientDetail) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('patient-detail-update')
                                                <a href="{{ route('patient-details.edit', $patientDetail) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('patient-detail-delete')
                                                <a href="#" data-href="{{ route('patient-details.destroy', $patientDetail) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $patientDetails->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
