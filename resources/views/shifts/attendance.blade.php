@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Shift Attendance Analysis</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('shifts.index') }}">Shifts</a></li>
                    <li class="breadcrumb-item active">Attendance Analysis</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Shift: {{ $shift->name }} ({{ $shift->time_range }})</h3>
                <div class="card-tools">
                    <a href="{{ route('shifts.index') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-arrow-left"></i> Back to Shifts
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div id="filter" class="collapse show">
                    <div class="card-body border">
                        <form action="" method="get" role="form" autocomplete="off">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="date" name="date" class="form-control" value="{{ request('date', now()->format('Y-m-d')) }}">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control select2">
                                            <option value="">All</option>
                                            <option value="on_time" {{ request('status') == 'on_time' ? 'selected' : '' }}>On Time</option>
                                            <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                                            <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="overtime" {{ request('status') == 'overtime' ? 'selected' : '' }}>Overtime</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <button type="submit" class="btn btn-info">Filter</button>
                                    @if(request()->hasAny(['date', 'status']))
                                        <a href="{{ route('shifts.attendance', $shift->id) }}" class="btn btn-secondary">Clear</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-3">
                        <div class="info-box bg-info">
                            <span class="info-box-icon"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Users</span>
                                <span class="info-box-number">{{ $users->count() }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-success">
                            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Present</span>
                                <span class="info-box-number">{{ $presentCount }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-warning">
                            <span class="info-box-icon"><i class="fas fa-clock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Late</span>
                                <span class="info-box-number">{{ $lateCount }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="info-box bg-danger">
                            <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Absent</span>
                                <span class="info-box-number">{{ $absentCount }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table table-striped" id="laravel_datatable">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>External ID</th>
                            <th>Shift Time</th>
                            <th>Check-in Time</th>
                            <th>Check-out Time</th>
                            <th>Status</th>
                            <th>Late By</th>
                            <th>Overtime</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            @php
                                $attendance = $attendances->where('user_id', $user->id)->first();
                                $status = 'absent';
                                $lateBy = '-';
                                $overtime = '-';
                                $checkInTime = '-';
                                $checkOutTime = '-';

                                if ($attendance) {
                                    $checkInTime = $attendance->date_time->format('H:i');
                                    $checkOutTime = $attendance->date_time->addHours(8)->format('H:i'); // Assuming 8-hour shift

                                    $shiftStartTime = \Carbon\Carbon::parse($shift->start_time);
                                    $shiftEndTime = \Carbon\Carbon::parse($shift->end_time);
                                    $checkIn = \Carbon\Carbon::parse($attendance->date_time);

                                    // Check if late
                                    if ($checkIn->gt($shiftStartTime->addMinutes(15))) {
                                        $status = 'late';
                                        $lateBy = $shiftStartTime->addMinutes(15)->diffInMinutes($checkIn) . ' min';
                                    } else {
                                        $status = 'on_time';
                                    }

                                    // Check for overtime
                                    if ($checkIn->gt($shiftEndTime)) {
                                        $status = 'overtime';
                                        $overtime = $shiftEndTime->diffInMinutes($checkIn) . ' min';
                                    }
                                }
                            @endphp
                            <tr>
                                <td>
                                    <div>{{ $user->name }}</div>
                                    <small class="text-muted">{{ $user->email }}</small>
                                </td>
                                <td>{{ $user->external_id ?? '-' }}</td>
                                <td>{{ $shift->time_range }}</td>
                                <td>{{ $checkInTime }}</td>
                                <td>{{ $checkOutTime }}</td>
                                <td>
                                    @if($status == 'on_time')
                                        <span class="badge badge-success">On Time</span>
                                    @elseif($status == 'late')
                                        <span class="badge badge-warning">Late</span>
                                    @elseif($status == 'overtime')
                                        <span class="badge badge-info">Overtime</span>
                                    @else
                                        <span class="badge badge-danger">Absent</span>
                                    @endif
                                </td>
                                <td>{{ $lateBy }}</td>
                                <td>{{ $overtime }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No users assigned to this shift.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $users->withQueryString()->links() }}
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
