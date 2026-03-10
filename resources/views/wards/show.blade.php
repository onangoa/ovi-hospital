@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>@lang('Ward Details')</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('wards.index') }}">@lang('Ward List')</a></li>
                        <li class="breadcrumb-item active">@lang('Ward Details')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">@lang('Ward Details')</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                    <table class="table table-bordered">
                        <tr>
                            <th>@lang('Ward Name')</th>
                            <td>{{ $ward->name }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Capacity')</th>
                            <td>{{ $ward->capacity }}</td>
                        </tr>
                        <tr>
                            <th>@lang('Status')</th>
                            <td>
                                @if($ward->status == 'active')
                                    <span class="badge badge-pill badge-success">@lang('Active')</span>
                                @else
                                    <span class="badge badge-pill badge-danger">@lang('Inactive')</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>@lang('Description')</th>
                            <td>{{ $ward->description ?? 'N/A' }}</td>
                        </tr>
                    </table>

                    </div>
                    
                    <!-- Assigned Patients -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>@lang('Assigned Patients')</h4>
                            @can('patient-detail-read')
                                <div class="mb-3">
                                    <button type="button" class="btn btn-outline btn-info" data-toggle="modal" data-target="#assignPatientsModal">
                                        @lang('Assign Patients')
                                    </button>
                                </div>
                            @endcan
                            @if($ward->patients->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>@lang('Patient Name')</th>
                                            <th>@lang('Assigned At')</th>
                                            <th>@lang('Discharged At')</th>
                                            <th>@lang('Actions')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ward->patients as $patient)
                                            <tr>
                                                <td>{{ $patient->name }}</td>
                                                <td>{{ $patient->pivot->created_at ? \Carbon\Carbon::parse($patient->pivot->created_at)->format('Y-m-d') : 'N/A' }}</td>
                                                <td>{{ $patient->pivot->discharged_at ? \Carbon\Carbon::parse($patient->pivot->discharged_at)->format('Y-m-d') : 'N/A' }}</td>
                                                <td>
                                                    @if(!$patient->pivot->discharged_at)
                                                        @can('ward-update')
                                                            <a href="{{ route('wards.discharge-patient', [$ward, $patient]) }}" class="btn btn-outline btn-warning btn-sm" onclick="event.preventDefault(); if(confirm('@lang('Are you sure you want to discharge this patient?')')) document.getElementById('discharge-patient-{{ $patient->id }}').submit();">@lang('Discharge')</a>
                                                            <form id="discharge-patient-{{ $patient->id }}" action="{{ route('wards.discharge-patient', [$ward, $patient]) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('PATCH')
                                                            </form>
                                                        @endcan
                                                    @else
                                                        <span class="badge badge-pill badge-secondary">@lang('Discharged')</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>@lang('No patients assigned to this ward.')</p>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Assigned Doctors -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h4>@lang('Assigned Doctors')</h4>
                            @can('doctor-detail-read')
                                @if($assignPatient != 1)
                                    <!-- <div class="mb-3">
                                        <button type="button" class="btn btn-outline btn-info" data-toggle="modal" data-target="#assignDoctorsModal">
                                            @lang('Assign Doctors')
                                        </button>
                                    </div> -->
                                @endif
                            @endcan
                            @if($wardAppointments->count() > 0)
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Schedule</th>
                                            <th>Time</th>
                                            <th>Doctor</th>
                                            <!-- <th>Patient</th>
                                            <th>Ward</th> -->
                                            <th>Type</th>
                                            <!-- <th>Status</th> -->
                                            @if($assignPatient != 1)
                                                <th data-orderable="false">Actions</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($wardAppointments as $assignment)
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
                                                    @if($assignment->start_time)
                                                        {{ \Carbon\Carbon::parse($assignment->start_time)->format('h:i A') }}
                                                        @if($assignment->end_time)
                                                            - {{ \Carbon\Carbon::parse($assignment->end_time)->format('h:i A') }}
                                                        @endif
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $assignment->doctor->name }}</strong>
                                                    @if($assignment->doctor->doctorDetails)
                                                        <br><small class="text-muted">{{ $assignment->doctor->doctorDetails->license_number ?? '' }}</small>
                                                    @endif
                                                </td>
                                                <!-- <td>
                                                    @if($assignment->patient_id)
                                                        {{ $assignment->patient->name }}
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $assignment->ward->name }}</td> -->
                                                <td>
                                                    @if($assignment->isAppointment())
                                                        <span class="badge badge-info">Appointment</span>
                                                    @else
                                                        <span class="badge badge-warning">Ward Assignment</span>
                                                    @endif
                                                </td>
                                                <!-- <td>
                                                    @if($assignPatient == 1)
                                                        <span class="badge badge-success">Available for Assignment</span>
                                                    @else
                                                        <span class="badge badge-{{ $assignment->status == 'completed' ? 'success' : ($assignment->status == 'cancelled' ? 'danger' : 'primary') }}">
                                                            {{ ucfirst($assignment->status ?? 'scheduled') }}
                                                        </span>
                                                    @endif
                                                </td> -->
                                                @if($assignPatient != 1)
                                                    <td>
                                                        @can('ward-update')
                                                            <a href="{{ route('wards.remove-doctor-assignment', [$ward, $assignment]) }}" class="btn btn-outline btn-danger btn-sm" onclick="event.preventDefault(); if(confirm('@lang('Are you sure you want to remove this assignment?')')) document.getElementById('remove-assignment-{{ $assignment->id }}').submit();">@lang('Remove Assignment')</a>
                                                            <form id="remove-assignment-{{ $assignment->id }}" action="{{ route('wards.remove-doctor-assignment', [$ward, $assignment]) }}" method="POST" style="display: none;">
                                                                @csrf
                                                                @method('DELETE')
                                                            </form>
                                                        @endcan
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>@lang('No doctors assigned to this ward.')</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group mt-4">
                        @can('ward-update')
                            <a href="{{ route('wards.edit', $ward) }}" class="btn btn-outline btn-info">@lang('Edit')</a>
                        @endcan
                        <a href="{{ route('wards.index') }}" class="btn btn-outline btn-secondary">@lang('Back')</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @include('wards.partials.assign-patients')
    @include('wards.partials.assign-doctors')
@endsection