@extends('layouts.layout')

@section('one_page_css')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
@endsection
@section('one_page_js')
    <!-- ChartJS -->
    <script src="{{ asset('assets/plugins/chart.js/Chart.min.js') }}"></script>
@endsection
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>@lang('Dashboard')</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">@lang('Dashboard')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-bezier-curve"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Department')</span>
                    <span class="info-box-number">{{ $dashboardCounts['departments'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-user-md"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Doctor')</span>
                    <span class="info-box-number">{{ $dashboardCounts['doctors'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-user-injured"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Patient')</span>
                    <span class="info-box-number">{{ $dashboardCounts['patients'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-calendar-check"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">@lang('Patient Appointment')</span>
                    <span class="info-box-number">{{ $dashboardCounts['appointments'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-file-alt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Patient Case Studies')</span>
                    <span class="info-box-number">{{ $dashboardCounts['caseStudies'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-pills"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Prescription')</span>
                    <span class="info-box-number">{{ $dashboardCounts['prescriptions'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-danger"><i class="fas fa-bed"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Wards')</span>
                    <span class="info-box-number">{{ $dashboardCounts['wards'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-warning"><i class="fas fa-pills"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Drug Orders')</span>
                    <span class="info-box-number">{{ $dashboardCounts['drugOrders'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-primary"><i class="fas fa-heartbeat"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Care Plans')</span>
                    <span class="info-box-number">{{ $dashboardCounts['carePlans'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-secondary"><i class="fas fa-stethoscope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Wellness Checks')</span>
                    <span class="info-box-number">{{ $dashboardCounts['wellnessChecks'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-success"><i class="fas fa-procedures"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Therapy Reports')</span>
                    <span class="info-box-number">{{ $dashboardCounts['therapyReports'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-12">
            <div class="info-box">
                <span class="info-box-icon bg-info"><i class="fas fa-flask"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">@lang('Lab Reports')</span>
                    <span class="info-box-number">{{ $dashboardCounts['labReports'] }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- MONTHLY APPOINTMENTS CHART -->
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Monthly Appointments Trend')</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="appointmentsChart" class="custom-dashbord-mix"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <!-- WARD DISTRIBUTION CHART -->
            <div class="card card-success">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Ward Distribution')</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="wardChart" class="custom-dashbord-mix"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <!-- PATIENT VS DOCTORS RATIO -->
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Patient vs Doctors Ratio')</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="ratioChart" class="custom-dashbord-mix"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-6">
            <!-- WEEKLY WELLNESS ENGAGEMENT -->
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Weekly Wellness Engagement')</h3>
                </div>
                <div class="card-body">
                    <div class="chart">
                        <canvas id="engagementChart" class="custom-dashbord-mix"></canvas>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>

@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/dashboard/view.js') }}"></script>
@endpush
