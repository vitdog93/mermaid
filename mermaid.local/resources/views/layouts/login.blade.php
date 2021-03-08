<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Bigmarket CP System</title>

    <!-- Styles -->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet">
    <!-- Vendor styles -->
    <link rel="stylesheet" href="{{ asset('assets/bower_components/material-design-iconic-font/dist/css/material-design-iconic-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/animate.css/animate.min.css') }}">

    <style media="screen">
        .login__block {
            -webkit-animation-name: auto;
            animation-name: auto;
            animation-duration: .3s;
            animation-fill-mode: none;
            border-radius: 2px;
        }
    </style>
</head>
<body data-ma-theme="orange">
<div class="login">
    @yield('content')
</div>

<!-- Vendors -->
<script src="{{ asset('assets/bower_components/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/popper.js/dist/umd/popper.min.js') }}"></script>
<script src="{{ asset('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- App functions and actions -->
<script src="{{ asset('assets/js/app.min.js') }}"></script>
</body>
</html>
