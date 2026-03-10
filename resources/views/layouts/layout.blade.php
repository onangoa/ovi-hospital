<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="site-url" content="{{ url('/') }}">
    <title>
        {{ $ApplicationSetting->item_short_name }}
        @if (isset($title) && !empty($title))
            {{ " | ".$title }}
        @endif
    </title>
    @include('thirdparty.css_back')
    @yield('one_page_css')
    <style>
        .card-header, .btn-info {
            background-color: #EBA687 !important;
            border-color: #EBA687 !important;
        }
        .card-outline {
            border-top: 3px solid  #EBA687 !important;
        }
        .sidebar-dark-info .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-info .nav-sidebar>.nav-item>.nav-link.active {
            background-color: #EBA687 !important;
        }
        #t1 th {
            border-color: #EBA687 !important;
            background-color:#EBA687 !important;
        }
        .table-dark td, .table-dark th, .table-dark thead th {
            border-color: #EBA687 !important;
        }
        .table-dark {
            background-color: #EBA687 !important;
        }
        .logo-container img {
                max-width: 130px;
                height: auto;
            }
    </style>
    <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/custom/layout.js') }}"></script>
    @stack('header')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    @include('layouts.header')
    @include('layouts.sidebar')
    <div class="content-wrapper">
        <div class="content">
            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>
    @include('layouts.footer')
</div>
@include('thirdparty.js_back')
@yield('one_page_js')
@include('thirdparty.js_back_footer')
@yield('script')
@stack('footer')
</body>
</html>
