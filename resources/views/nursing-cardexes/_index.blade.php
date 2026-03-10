@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('nursing-cardexes-create')
                        <h3><a href="{{ route('nursing-cardexes.create') }}" class="btn btn-outline btn-info">+ Add Nursing Cardex</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Nursing Cardex List</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Nursing Cardex List</h3>
                    <div class="card-tools">
                        @can('nursing-cardexes-create')
                            <a class="btn btn-primary" target="_blank" href="{{ route('nursing-cardexes.index') }}?export=1"><i class="fas fa-cloud-download-alt"></i> Export</a>
                            <a class="btn btn-danger" target="_blank" href="{{ route('nursing-cardexes.index') }}?export_pdf=1"><i class="fas fa-file-pdf"></i> PDF Export</a>
                        @endcan
                        <button class="btn btn-default" data-toggle="collapse" href="#filter"><i class="fas fa-filter"></i> Filter</button>
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
                                            <label>Patient</label>
                                            <input type="text" name="patient_id" class="form-control" value="{{ request()->patient_id }}" placeholder="Patient">
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label>@lang('Conducted by')</label>
                                            <input type="text" name="nurse_on_duty_name" class="form-control" value="{{ request()->nurse_on_duty_name }}" placeholder="@lang('Conducted by')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('nursing-cardexes.index') }}" class="btn btn-secondary">Clear</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>Patient</th>
                                <th>@lang('Conducted by')</th>
                                <th>Brief Report</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nursingCardexes as $nursingCardex)
                                <tr>
                                    <td>{{ $nursingCardex->patient->name }}</td>
                                    <td>{{ $nursingCardex->nurse_on_duty_name }}</td>
                                    <td>{{ $nursingCardex->brief_report }}</td>
                                    <td>{{ $nursingCardex->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('nursing-cardexes.show', $nursingCardex->id) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="View"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('nursing-cardexes-update')
                                                <a href="{{ route('nursing-cardexes.edit', $nursingCardex->id) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="Edit"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('nursing-cardexes-delete')
                                                <a href="#" data-href="{{ route('nursing-cardexes.destroy', $nursingCardex->id) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $nursingCardexes->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
