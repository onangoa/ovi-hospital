@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    @can('medical-referrals-create')
                        <h3><a href="{{ route('medical-referrals.create') }}" class="btn btn-outline btn-info">+ Add Medical Referral</a>
                            <span class="pull-right"></span>
                        </h3>
                    @endcan
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Medical Referral List</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Medical Referral List</h3>
                    <div class="card-tools">
                        @can('medical-referrals-create')
                            <a class="btn btn-primary" target="_blank" href="{{ route('medical-referrals.index') }}?export=1"><i class="fas fa-cloud-download-alt"></i> Export</a>
                            <a class="btn btn-danger" target="_blank" href="{{ route('medical-referrals.index') }}?export_pdf=1"><i class="fas fa-file-pdf"></i> PDF Export</a>
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
                                            <input type="text" name="referring_doctor_name" class="form-control" value="{{ request()->referring_doctor_name }}" placeholder="@lang('Conducted by')">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('medical-referrals.index') }}" class="btn btn-secondary">Clear</a>
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
                                <th>Reason</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($medicalReferrals as $medicalReferral)
                                <tr>
                                    <td>{{ $medicalReferral->patient->name }}</td>
                                    <td>{{ optional($medicalReferral->referringDoctor)->name }}</td>
                                    <td>{{ $medicalReferral->reason_for_referral }}</td>

                                    <td>{{ $medicalReferral->created_at->format('d-m-Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('medical-referrals.show', $medicalReferral->id) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="View"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            @can('medical-referrals-update')
                                                <a href="{{ route('medical-referrals.edit', $medicalReferral->id) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="Edit"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            @endcan
                                            @can('medical-referrals-delete')
                                                <a href="#" data-href="{{ route('medical-referrals.destroy', $medicalReferral->id) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $medicalReferrals->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
@include('layouts.delete_modal')
@endsection
