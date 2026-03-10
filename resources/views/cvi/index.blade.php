@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('cvi-create')
                        <h3>
                            <a href="{{ route('cvi.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Child Vitality Index')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Child Vitality Index List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Child Vitality Index List')</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <a class="btn btn-primary" target="_blank" href="{{ route('cvi.index') }}?export=1">
                                <i class="fas fa-file-excel"></i> @lang('Export CSV')
                            </a>
                            <a class="btn btn-danger" target="_blank" href="{{ route('cvi.index') }}?export_pdf=1">
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
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('cvi.index') }}" class="btn btn-secondary">@lang('Clear')</a>
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
                                <th>@lang('Score')</th>
                                <th>@lang('Vitality Score')</th>
                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cvis as $cvi)
                                <tr>
                                    <td>{{ $cvi->patient->name ?? 'N/A' }}</td>
                                    <td>{{ $cvi->date }}</td>
                                    <td>{{ $cvi->score }}</td>
                                    <td>{{ $cvi->vitality_score }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('cvi.show', $cvi) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('cvi-update')
                                                <a href="{{ route('cvi.edit', $cvi) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('cvi-delete')
                                                <a href="#" data-href="{{ route('cvi.destroy', $cvi) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $cvis->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection