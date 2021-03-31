<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home | Bookshop Responsive Bootstrap4 Template</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="success" content="{{ __('success_text') }}">
    <meta name="info" content="{{ __('info_text') }}">
    <meta name="warning" content="{{ __('success_tex') }}">
    <meta name="error" content="{{ __('error_text') }}">
    <!-- Favicons -->
    <link rel="shortcut icon" href="{{asset('fontend/images/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('fontend/images/icon.png')}}">

    <!-- Google font (font-family: 'Roboto', sans-serif; Poppins ; Satisfy) -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,300i,400,400i,500,600,600i,700,700i,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">


    <!-- Stylesheets -->
    <link rel="stylesheet" href="{{asset('fontend/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('fontend/css/plugins.css')}}">
    <link rel="stylesheet" href="{{asset('fontend/style.css')}}">


    <!-- Cusom css -->
    <link rel="stylesheet" href="{{asset('fontend/css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('common/common.css')}}">

    <!-- Modernizer js -->
    <script src="{{asset('fontend/js/vendor/modernizr-3.5.0.min.js')}}"></script>
</head>
<body>
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->

<!-- Main wrapper -->
<div class="wrapper" id="wrapper">
    <!-- Header -->
    @include('layouts.header2')
    <!-- //Header -->
    <!-- Start Search Popup -->
    @include('layouts.search')
    <!-- End Search Popup -->

    <!-- Start Content -->
    @hasSection('content')
        @yield('content')
    @endif

    <!-- End Content -->
    <!-- Footer Area -->
    @include('layouts.footer')
    <!-- //Footer Area -->
</div>
<!-- //Main wrapper -->

<!-- JS Files -->
<script src="{{asset('fontend/js/vendor/jquery-3.2.1.min.js')}}"></script>
<script src="{{asset('fontend/js/popper.min.js')}}"></script>
<script src="{{asset('fontend/js/bootstrap.min.js')}}"></script>
<script src="{{asset('fontend/js/plugins.js')}}"></script>
<script src="{{asset('fontend/js/active.js')}}"></script>
<script src="{{asset('common/common.js')}}"></script>

@hasSection('js')
    @yield('js')
@endif

</body>
</html>