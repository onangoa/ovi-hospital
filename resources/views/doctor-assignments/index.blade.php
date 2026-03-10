@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>
                    <a href="{{ route('doctor-assignments.create') }}" class="btn btn-outline btn-info">
                        + New Assignment
                    </a>
                    <span class="pull-right"></span>
                </h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Doctor Assignments</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Doctor Assignments</h3>
                <div class="card-tools">
                    <button class="btn btn-default" data-toggle="collapse" href="#filter">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
                <div class="card-body">
                    <div id="filter" class="collapse @if(request()->isFilterActive) show @endif">
                        <div class="card-body border">
                            <form action="" method="get" role="form" autocomplete="off">
                                <input type="hidden" name="isFilterActive" value="true">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Date">
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Doctor</label>
                                            <select name="doctor_id" class="form-control">
                                                <option value="">All Doctors</option>
                                                @foreach($doctors as $doctor)
                                                    <option value="{{ $doctor->id }}" {{ request('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                                        {{ $doctor->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Ward</label>
                                            <select name="ward_id" class="form-control">
                                                <option value="">All Wards</option>
                                                @foreach($wards as $ward)
                                                    <option value="{{ $ward->id }}" {{ request('ward_id') == $ward->id ? 'selected' : '' }}>
                                                        {{ $ward->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label>Type</label>
                                            <select name="type" class="form-control">
                                                <option value="">All Types</option>
                                                <option value="appointments" {{ request('type') == 'appointments' ? 'selected' : '' }}>Appointments</option>
                                                <option value="ward_assignments" {{ request('type') == 'ward_assignments' ? 'selected' : '' }}>Ward Assignments</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                        @if(request()->isFilterActive)
                                            <a href="{{ route('doctor-assignments.index') }}" class="btn btn-secondary">Clear</a>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <table class="table table-striped" id="laravel_datatable">
                        <thead>
                            <tr>
                                <th>Schedule</th>
                                <th>Time</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Ward</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th data-orderable="false">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($assignments as $assignment)
                                <tr>
                                    <td>
                                        @if($assignment->weekday)
                                            <span class="badge badge-info">Every {{ $assignment->weekday }}</span>
                                        @elseif($assignment->appointment_date)
                                            {{ $assignment->appointment_date->format('M d, Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $assignment->start_time->format('h:i A') }}
                                        @if($assignment->end_time)
                                            - {{ $assignment->end_time->format('h:i A') }}
                                        @endif
                                    </td>
                                    <td>{{ $assignment->doctor->name }}</td>
                                    <td>
                                        @if($assignment->patient_id)
                                            {{ $assignment->patient->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->ward_id)
                                            {{ $assignment->ward->name }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($assignment->isAppointment())
                                            <span class="badge badge-info">Appointment</span>
                                        @else
                                            <span class="badge badge-warning">Ward Assignment</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-{{ $assignment->status == 'completed' ? 'success' : ($assignment->status == 'cancelled' ? 'danger' : 'primary') }}">
                                            {{ ucfirst($assignment->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('doctor-assignments.show', $assignment) }}" class="btn btn-info btn-outline btn-circle btn-lg" data-toggle="tooltip" title="View"><i class="fa fa-eye ambitious-padding-btn"></i></a>
                                            <a href="{{ route('doctor-assignments.edit', $assignment) }}" class="btn btn-success btn-outline btn-circle btn-lg" data-toggle="tooltip" title="Edit"><i class="fa fa-edit ambitious-padding-btn"></i></a>
                                            <a href="#" data-href="{{ route('doctor-assignments.destroy', $assignment) }}" class="btn btn-danger btn-outline btn-circle btn-lg" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash ambitious-padding-btn"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">No assignments found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $assignments->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@include('layouts.delete_modal')
@endsection