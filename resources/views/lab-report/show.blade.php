@extends('layouts.layout')
@section('one_page_js')
<script src="{{ asset('assets/plugins/magnify/dist/jquery.magnify.js') }}"></script>
@endsection

@section('one_page_css')
     <link href="{{ asset('assets/plugins/magnify/dist/jquery.magnify.css') }}" rel="stylesheet">
@endsection
@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">
                        <a href="{{ route('lab-reports.index') }}">@lang('Lab Report')</a></li>
                    <li class="breadcrumb-item active">@lang('Lab Report Info')</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">@lang('Lab Reports Info')</h3>
                <div class="card-tools">
                    @can('lab-report-update')
                        <a href="{{ route('lab-reports.edit', $labReport) }}" class="btn btn-primary">@lang('Edit')</a>
                    @endcan
                    <a href="{{ route('lab-reports.exportPdf', $labReport) }}" class="btn btn-danger"><i class="fas fa-file-pdf"></i> Export to PDF</a>
                 </div>
            </div>
            <div id="print-area" class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="invoice p-3 mb-3">
                            <div class="text-center">
                                <p class="text-right m-0">@lang('Report Date'): {{ date($companySettings->date_format ?? 'Y-m-d', strtotime($labReport->date)) }}<br></p>
                                <p class="text-right">@lang('Lab Report ID') #{{ str_pad($labReport->id, 4, '0', STR_PAD_LEFT) }}<br></p>
                               
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="user_id">@lang('Patient Name')</label>
                                        <p>{{ $labReport->user->name }}</p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="date">@lang('Report Date')</label>
                                        <p>{{ date($companySettings->date_format ?? 'Y-m-d', strtotime($labReport->date)) }}</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <label>@lang('Lab Report')</label>
                                    {!! str_replace(["script"], ["noscript"], $labReport->report) !!}
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($labReport->photo))
                                        @foreach (json_decode($labReport->photo) as $pic)
                                            @if(pathinfo($pic, PATHINFO_EXTENSION) != "pdf")
                                                <a data-magnify="gallery" data-caption="Report"
                                                    href="{{ asset($pic) }}">
                                                    <img id="custom-mw-heo" class="rounded" src="{{ asset($pic) }}" alt="">
                                                </a>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    @if(isset($labReport->photo))
                                        @foreach (json_decode($labReport->photo) as $pic)
                                            @if(pathinfo($pic, PATHINFO_EXTENSION) == "pdf")
                                                <a class="my_card" href="{{ asset('storage/'.$pic) }}" target="_blank">
                                                    <i class="fas fa-file-pdf fa-7x" class="custom-padding-10"></i>
                                                </a>
                                            @endif
                                        @endforeach
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
@endsection

@push('footer')
    <script src="{{ asset('assets/js/custom/lab-report/show.js') }}"></script>
@endpush
