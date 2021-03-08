<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Mermaid CP System</title>

    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/animate.css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/jquery.scrollbar/jquery.scrollbar.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/select2/dist/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/sweetalert2/sweetalert2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=1.0.0') }}">
    <style media="screen">
        .alert--notify {
            z-index: 1051!important;
        }
    </style>
@yield('header')

<!-- App styles -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i&display=swap&subset=vietnamese" rel="stylesheet">
</head>
<body data-ma-theme="brown">
<main class="main">
    <div class="page-loader">
        <div class="page-loader__spinner">
            <svg viewBox="25 25 50 50">
                <circle cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"/>
            </svg>
        </div>
    </div>
    @include('components.header')
    @yield('content')
    <footer class="footer hidden-xs-down">
        <p>© Mermaid Store CP System. All rights reserved.</p>
    </footer>
</main>
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    @csrf
</form>
<!-- Vendors -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/select2/dist/js/select2.full.js') }}"></script>
<script src="{{ asset('assets/bower_components/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/jquery-scrollLock/jquery-scrollLock.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/tinymce/tinymce.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/bower_components/sweetalert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.number.js') }}"></script>
<script src="{{ asset('assets/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('assets/js/jquery.form.js') }}"></script>
<script src="{{ asset('assets/js/upload.js') }}"></script>

@yield('script')

<!-- App functions and actions -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js?v=1.0.0') }}"></script>

@include('components.flash')
</body>
</html>
