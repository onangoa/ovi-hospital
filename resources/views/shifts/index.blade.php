@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h3>Shifts</h3>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active">Shifts</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Shifts Management</h3>
                <div class="card-tools">
                    <a href="{{ route('shifts.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Shift
                    </a>
                    <button class="btn btn-default" data-toggle="collapse" href="#filter">
                        <i class="fas fa-filter"></i> Filter
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div id="filter" class="collapse @if(request()->hasAny(['status', 'search'])) show @endif">
                    <div class="card-body border">
                        <form action="" method="get" role="form" autocomplete="off">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Search</label>
                                        <input type="text" name="search" class="form-control" value="{{ request('search') }}" placeholder="Search by name">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control select2">
                                            <option value="">All</option>
                                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <button type="submit" class="btn btn-info">Filter</button>
                                    @if(request()->hasAny(['status', 'search']))
                                        <a href="{{ route('shifts.index') }}" class="btn btn-secondary">Clear</a>
                                    @endif
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <table class="table table-striped" id="laravel_datatable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Duration</th>
                            <th>Assigned Users</th>
                            <th>Status</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($shifts as $shift)
                            <tr>
                                <td>{{ $shift->name }}</td>
                                <td>{{ $shift->start_time->format('h:i A') }}</td>
                                <td>{{ $shift->end_time->format('h:i A') }}</td>
                                <td>{{ number_format($shift->duration, 1) }} hours</td>
                                <td>{{ $shift->users->count() }} users</td>
                                <td>
                                    @if($shift->is_active)
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $shift->description ? Str::limit($shift->description, 50) : '-' }}</td>
                                <td>
                                    <a href="{{ route('shifts.edit', $shift->id) }}" class="btn btn-info btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="{{ route('shifts.attendance', $shift->id) }}" class="btn btn-success btn-sm">
                                        <i class="fas fa-chart-bar"></i> Attendance
                                    </a>
                                    <form action="{{ route('shifts.destroy', $shift->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this shift?')">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No shifts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $shifts->withQueryString()->links() }}
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
