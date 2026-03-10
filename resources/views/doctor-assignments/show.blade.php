@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('doctor-assignments.index') }}">Doctor Assignments</a></li>
                    <li class="breadcrumb-item active">Doctor Assignment Details</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Doctor Assignment Details</h3>
                <div class="card-tools">
                    <a href="{{ route('doctor-assignments.edit', $doctorAssignment) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th width="30%">Assignment Type</th>
                                <td>
                                    @if($doctorAssignment->isAppointment())
                                        <span class="badge badge-info">Patient Appointment</span>
                                    @else
                                        <span class="badge badge-warning">Ward Assignment</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Doctor</th>
                                <td>{{ $doctorAssignment->doctor->name }}</td>
                            </tr>
                            <tr>
                                <th>Patient</th>
                                <td>
                                    @if($doctorAssignment->patient_id)
                                        {{ $doctorAssignment->patient->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Ward</th>
                                <td>
                                    @if($doctorAssignment->ward_id)
                                        {{ $doctorAssignment->ward->name }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>
                                    <span class="badge badge-{{ $doctorAssignment->status == 'completed' ? 'success' : ($doctorAssignment->status == 'cancelled' ? 'danger' : 'primary') }}">
                                        {{ ucfirst($doctorAssignment->status) }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered table-striped">
                            <tr>
                                <th width="30%">Schedule Type</th>
                                <td>
                                    @if($doctorAssignment->weekday)
                                        <span class="badge badge-info">Recurring ({{ $doctorAssignment->weekday }})</span>
                                    @else
                                        <span class="badge badge-primary">Specific Date</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th width="30%">Assignment Date</th>
                                <td>
                                    @if($doctorAssignment->appointment_date)
                                        {{ $doctorAssignment->appointment_date->format('M d, Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            @if($doctorAssignment->weekday)
                            <tr>
                                <th>Weekday</th>
                                <td>{{ $doctorAssignment->weekday }}</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Start Time</th>
                                <td>{{ $doctorAssignment->start_time->format('h:i A') }}</td>
                            </tr>
                            <tr>
                                <th>End Time</th>
                                <td>
                                    @if($doctorAssignment->end_time)
                                        {{ $doctorAssignment->end_time->format('h:i A') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Date</th>
                                <td>{{ $doctorAssignment->created_at ? $doctorAssignment->created_at->format('M d, Y h:i A') : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                @if($doctorAssignment->isAppointment() && $doctorAssignment->problem)
                    <div class="row mt-3">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h5 class="card-title">Problem/Reason</h5>
                                </div>
                                <div class="card-body">
                                    <p>{{ $doctorAssignment->problem }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="card-footer">
                <a href="{{ route('doctor-assignments.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection