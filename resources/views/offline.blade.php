@extends('layouts.layout')

@section('one_page_css')
    <link href="{{ asset('assets/css/dashboard.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h2>@lang('Offline Mode')</h2>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">@lang('Dashboard')</a></li>
                        <li class="breadcrumb-item active">@lang('Offline')</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <div class="row">
        <div class="col-12">
            <div class="card card-warning">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('You are currently offline')</h3>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <i class="fas fa-wifi fa-5x mb-3" style="color: #ffc107;"></i>
                        <h4 class="mb-3">@lang('No Internet Connection')</h4>
                        <p class="mb-4">@lang('It looks like you have lost your internet connection. Some features may not be available until you reconnect.')</p>
                        
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> 
                            <strong>@lang('Note:')</strong> 
                            @lang('You can still access previously viewed pages and forms that have been cached. Any changes you make will be synchronized when you reconnect.')
                        </div>

                        <button onclick="window.location.reload()" class="btn btn-warning">
                            <i class="fas fa-sync-alt"></i> @lang('Try Reconnecting')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card card-info">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Available Offline Features')</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success"></i> 
                            @lang('View cached pages and reports')
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success"></i> 
                            @lang('Fill and submit forms (will sync when online)')
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success"></i> 
                            @lang('Access patient information from cache')
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-check-circle text-success"></i> 
                            @lang('View previously loaded clinical reports')
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-danger">
                <div class="card-header">
                    <h3 class="card-title custom-color-white">@lang('Features Requiring Connection')</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <i class="fas fa-times-circle text-danger"></i> 
                            @lang('Create new patient records')
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-times-circle text-danger"></i> 
                            @lang('Upload files or images')
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-times-circle text-danger"></i> 
                            @lang('Send notifications or emails')
                        </li>
                        <li class="list-group-item">
                            <i class="fas fa-times-circle text-danger"></i> 
                            @lang('Real-time data synchronization')
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
