@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Attendance Records</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Attendance</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Attendance Records</h3>
                <div class="card-tools">
                    <button class="btn btn-default" data-toggle="collapse" href="#filter">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="filter" class="collapse @if(request()->hasAny(['employee_no', 'start_date', 'device_name', 'event_type'])) show @endif">
                    <div class="card-body border">
                        <form action="" method="get" role="form" autocomplete="off">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Employee Number</label>
                                        <select name="employee_no" class="form-control select2">
                                            <option value="">All Employees</option>
                                            @foreach($employeeNumbers as $empNo)
                                                <option value="{{ $empNo }}" {{ request('employee_no') == $empNo ? 'selected' : '' }}>
                                                    {{ $empNo }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Device</label>
                                        <select name="device_name" class="form-control select2">
                                            <option value="">All Devices</option>
                                            @foreach($deviceNames as $device)
                                                <option value="{{ $device }}" {{ request('device_name') == $device ? 'selected' : '' }}>
                                                    {{ $device }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Event Type</label>
                                        <select name="event_type" class="form-control select2">
                                            <option value="">All Events</option>
                                            @foreach($eventTypes as $key => $type)
                                                <option value="{{ $key }}" {{ request('event_type') == $key ? 'selected' : '' }}>
                                                    {{ $type }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info">Filter</button>
                                    @if(request()->hasAny(['employee_no', 'start_date', 'device_name', 'event_type']))
                                        <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Clear</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-striped" id="laravel_datatable">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Employee</th>
                            <th>Device</th>
                            <th>Event Type</th>
                            <th>Event Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                            <tr>
                                <td>{{ $attendance->date_time ? $attendance->date_time->format('M d, Y H:i:s') : '-' }}</td>
                                <td>
                                    @if($attendance->user)
                                        <div>{{ $attendance->user->name }}</div>
                                        <!-- <small class="text-muted">{{ $attendance->employee_no_string }}</small> -->
                                    @else
                                        {{ $attendance->employee_no_string ?? '-' }}
                                    @endif
                                </td>
                                <td>{{ $attendance->device_name ?? '-' }}</td>
                                <td>
                                    @if($attendance->sub_event_type)
                                        <span class="badge badge-info">{{ $attendance->event_description }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $attendance->event_description ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No attendance records found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $attendances->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('.select2').select2({
            theme: 'bootstrap4',
            width: '100%'
        });
    });
</script>
@endpush
