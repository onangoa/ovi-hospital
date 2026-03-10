@extends('layouts.layout')

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>
                    Weekly Wellness Check Report
                </h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('dashboard') }}">@lang('Dashboard')</a>
                    </li>
                    <li class="breadcrumb-item active">
                        Weekly Wellness Check Report
                    </li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Filter</h3>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('weekly-wellness-checks.report') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">Select a date to view the report for that week:</label>
                                        <input type="date" name="date" id="date" class="form-control" value="{{ $selectedDate->format('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-2" style="margin-top: 32px;">
                                    <button type="submit" class="btn btn-primary btn-block">Generate Report</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Report for the week of {{ $startOfWeek->format('M d, Y') }} to {{ $endOfWeek->format('M d, Y') }}</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Summary</h3>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Total Wellness Checks Conducted:</strong> {{ $totalConducted }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h3 class="card-title">Patients Without a Wellness Check This Week</h3>
                                    </div>
                                    <div class="card-body">
                                        @if($patientsWithoutCheck->isEmpty())
                                            <p>All patients have had a wellness check this week.</p>
                                        @else
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Patient Name</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($patientsWithoutCheck as $patient)
                                                            <tr>
                                                                <td>{{ $patient->name }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
