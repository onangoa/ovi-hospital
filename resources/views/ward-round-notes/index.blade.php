@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('ward-round-notes-create')
                        <h3>
                            <a href="{{ route('ward-round-notes.create') }}" class="btn btn-outline btn-info">
                                + @lang('Add Ward Round Note')
                            </a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Ward Round Note List')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Ward Round Note List')</h3>
                    <div class="card-tools">
                        <div class="btn-group">
                            <a class="btn btn-primary" target="_blank" href="{{ route('ward-round-notes.index') }}?export=1">
                                <i class="fas fa-file-excel"></i> @lang('Export CSV')
                            </a>
                            <a class="btn btn-danger" target="_blank" href="{{ route('ward-round-notes.index') }}?export_pdf=1">
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
                                            <input type="text" name="attending_clinician" class="form-control" value="{{ request()->attending_clinician }}" placeholder="@lang('Conducted by')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">@lang('Submit')</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('ward-round-notes.index') }}" class="btn btn-secondary">@lang('Clear')</a>
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

                                <th data-orderable="false">@lang('Actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($wardRoundNotes as $wardRoundNote)
                                <tr>
                                    <td>{{ $wardRoundNote->patient->name ?? '' }}</td>
                                    <td>{{ optional($wardRoundNote->date)->format('Y-m-d') }}</td>
                                    <td>{{ $wardRoundNote->attendingClinician->name ?? '' }}</td>

                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('ward-round-notes.show', $wardRoundNote) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('View')"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('ward-round-notes-update')
                                                <a href="{{ route('ward-round-notes.edit', $wardRoundNote) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="@lang('Edit')"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('ward-round-notes-delete')
                                                <a href="#" data-href="{{ route('ward-round-notes.destroy', $wardRoundNote) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="@lang('Delete')"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $wardRoundNotes->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('layouts.delete_modal')
@endsection
