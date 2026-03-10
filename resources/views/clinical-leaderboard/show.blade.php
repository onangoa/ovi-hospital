@extends('layouts.layout')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h3>@lang('Clinical Leaderboard Details') - {{ $provider->name }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('clinical-leaderboard.index', ['start_date' => $startDate, 'end_date' => $endDate]) }}">@lang('Clinical Leaderboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Details')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                <h4 class="card-title">Clinical Activities for {{ $provider->name }}</h4>
                    <div class="card-tools">
                        <span class="badge badge-info">{{ $startDate }} to {{ $endDate }}</span>
                        <a href="{{ route('clinical-leaderboard.index', ['start_date' => $startDate, 'end_date' => $endDate]) }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-left"></i> @lang('Back to Leaderboard')
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Appointments Conducted -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary">
                            <h5 class="card-title mb-0 text-white">@lang('Appointments Conducted') ({{ $appointments->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($appointments->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>@lang('Date')</th>
                                                <th>@lang('Time')</th>
                                                <th>@lang('Patient')</th>
                                                <th>@lang('Ward')</th>
                                                <th>@lang('Problem')</th>
                                                <th>@lang('Status')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($appointments as $appointment)
                                                <tr>
                                                    <td>{{ $appointment->appointment_date }}</td>
                                                    <td>{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                                                    <td>{{ $appointment->patient_name ?? 'N/A' }}</td>
                                                    <td>{{ $appointment->ward_name ?? 'N/A' }}</td>
                                                    <td>{{ $appointment->problem ?? 'N/A' }}</td>
                                                    <td>{{ $appointment->status ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">@lang('No appointments found for this period.')</p>
                            @endif
                        </div>
                    </div>

                    <!-- Therapy Reports -->
                    <div class="card mb-4">
                        <div class="card-header bg-success">
                            <h5 class="card-title mb-0 text-white">@lang('Therapy Reports') ({{ $therapyReports->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($therapyReports->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>@lang('Date')</th>
                                                <th>@lang('Type')</th>
                                                <th>@lang('Patient')</th>
                                                <th>@lang('Notes')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($therapyReports as $report)
                                                <tr>
                                                    <td>{{ $report->date }}</td>
                                                    <td>{{ $report->type ?? 'N/A' }}</td>
                                                    <td>{{ $report->patient_name ?? 'N/A' }}</td>
                                                    <td>{{ $report->notes ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">@lang('No therapy reports found for this period.')</p>
                            @endif
                        </div>
                    </div>

                    <!-- Prescriptions -->
                    <div class="card mb-4">
                        <div class="card-header bg-info">
                            <h5 class="card-title mb-0 text-white">@lang('Prescriptions') ({{ $prescriptions->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($prescriptions->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>@lang('Date')</th>
                                                <th>@lang('Patient')</th>
                                                <th>@lang('Medication')</th>
                                                <th>@lang('Dosage')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($prescriptions as $prescription)
                                                <tr>
                                                    <td>{{ $prescription->prescription_date }}</td>
                                                    <td>{{ $prescription->patient_name ?? 'N/A' }}</td>
                                                    <td>{{ $prescription->medication ?? 'N/A' }}</td>
                                                    <td>{{ $prescription->dosage ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">@lang('No prescriptions found for this period.')</p>
                            @endif
                        </div>
                    </div>

                    <!-- Lab Requests -->
                    <div class="card mb-4">
                        <div class="card-header bg-warning">
                            <h5 class="card-title mb-0 text-white">@lang('Lab Requests') ({{ $labRequests->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($labRequests->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>@lang('Request Date')</th>
                                                <th>@lang('Patient')</th>
                                                <th>@lang('Test Type')</th>
                                                <th>@lang('Status')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($labRequests as $request)
                                                <tr>
                                                    <td>{{ $request->request_date }}</td>
                                                    <td>{{ $request->patient_name ?? 'N/A' }}</td>
                                                    <td>{{ $request->test_type ?? 'N/A' }}</td>
                                                    <td>{{ $request->status ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">@lang('No lab requests found for this period.')</p>
                            @endif
                        </div>
                    </div>

                    <!-- Radiology Requests -->
                    <div class="card mb-4">
                        <div class="card-header bg-danger">
                            <h5 class="card-title mb-0 text-white">@lang('Radiology Requests') ({{ $radiologyRequests->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($radiologyRequests->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>@lang('Request Date')</th>
                                                <th>@lang('Patient')</th>
                                                <th>@lang('Procedure')</th>
                                                <th>@lang('Status')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($radiologyRequests as $request)
                                                <tr>
                                                    <td>{{ $request->created_at }}</td>
                                                    <td>{{ $request->patient_name ?? 'N/A' }}</td>
                                                    <td>{{ $request->procedure ?? 'N/A' }}</td>
                                                    <td>{{ $request->status ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">@lang('No radiology requests found for this period.')</p>
                            @endif
                        </div>
                    </div>

                    <!-- Nursing Cardexes -->
                    <div class="card mb-4">
                        <div class="card-header bg-secondary">
                            <h5 class="card-title mb-0 text-white">@lang('Nursing Cardexes') ({{ $nursingCardexes->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($nursingCardexes->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>@lang('Date')</th>
                                                <th>@lang('Patient')</th>
                                                <th>@lang('Shift')</th>
                                                <th>@lang('Notes')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($nursingCardexes as $cardex)
                                                <tr>
                                                    <td>{{ $cardex->date }}</td>
                                                    <td>{{ $cardex->patient_name ?? 'N/A' }}</td>
                                                    <td>{{ $cardex->shift ?? 'N/A' }}</td>
                                                    <td>{{ $cardex->notes ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">@lang('No nursing cardexes found for this period.')</p>
                            @endif
                        </div>
                    </div>

                    <!-- Drug Orders -->
                    <div class="card mb-4">
                        <div class="card-header bg-dark">
                            <h5 class="card-title mb-0 text-white">@lang('Drug Orders') ({{ $drugOrders->count() }})</h5>
                        </div>
                        <div class="card-body">
                            @if($drugOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>@lang('Date')</th>
                                                <th>@lang('Patient')</th>
                                                <th>@lang('Medication')</th>
                                                <th>@lang('Status')</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($drugOrders as $order)
                                                <tr>
                                                    <td>{{ $order->date }}</td>
                                                    <td>{{ $order->patient_name ?? 'N/A' }}</td>
                                                    <td>{{ $order->medication ?? 'N/A' }}</td>
                                                    <td>{{ $order->status ?? 'N/A' }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <p class="text-muted">@lang('No drug orders found for this period.')</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection