@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('radiology-requests-create')
                        <h3><a href="{{ route('radiology-requests.create') }}" class="btn btn-outline btn-info">+ Add Radiology Request</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Radiology Request List</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Radiology Request List</h3>
                    <div class="card-tools">
                        @can('radiology-requests-create')
                            <div class="btn-group">
                                <a class="btn btn-primary" target="_blank" href="{{ route('radiology-requests.index') }}?export=1">
                                    <i class="fas fa-file-excel"></i> Export CSV
                                </a>
                                <a class="btn btn-danger" target="_blank" href="{{ route('radiology-requests.index') }}?export_pdf=1">
                                    <i class="fas fa-file-pdf"></i> Export PDF
                                </a>
                            </div>
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
                                            <label>Provider</label>
                                            <input type="text" name="provider_id" class="form-control" value="{{ request()->provider_id }}" placeholder="Provider">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('radiology-requests.index') }}" class="btn btn-secondary">Clear</a>
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
                                <th>Conducted by</th>
                                <th>Blood Group</th>
                                <th>Examination Type</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($radiologyRequests as $radiologyRequest)
                                <tr>
                                    <td>{{ optional($radiologyRequest->patient)->name ?? 'N/A' }}</td>
                                    <td>
                                        @if($radiologyRequest->provider_id)
                                            {{ App\Models\User::find($radiologyRequest->provider_id)->name ?? 'User ID: ' . $radiologyRequest->provider_id . ' (Not Found)' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ optional($radiologyRequest->patient)->blood_group ?? 'N/A' }}</td>
                                    <td>{{ implode(', ', $radiologyRequest->examination_type ?? []) }}</td>

                                    <td>{{ $radiologyRequest->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('radiology-requests.show', $radiologyRequest->id) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="View"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('radiology-requests-update')
                                                <a href="{{ route('radiology-requests.edit', $radiologyRequest->id) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="Edit"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('radiology-requests-delete')
                                                <a href="#" data-href="{{ route('radiology-requests.destroy', $radiologyRequest->id) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $radiologyRequests->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
