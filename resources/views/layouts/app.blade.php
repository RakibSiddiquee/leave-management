<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title', 'Leave Management')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="{{ asset('backend/adminlte/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    @yield('custom-css')
<!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend/adminlte/dist/css/AdminLTE.min.css') }}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('backend/adminlte/dist/css/skins/_all-skins.min.css') }}">
    <!-- iCheck -->

    <link rel="stylesheet" href="{{ asset('backend/css/backend-style.css') }}">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('common.header')
@include('common.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div id="app" class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    @include('common.footer')
</div>
<!-- ./wrapper -->

<script src="{{ asset('js/app.js') }}"></script>

<!-- jQuery 2.2.3 -->
<script src="{{ asset('backend/adminlte/plugins/jQuery/jquery-2.2.3.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('backend/js/jquery-ui-1.11.4.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->

<!-- Bootstrap 3.3.6 -->
<script src="{{ asset('backend/adminlte/bootstrap/js/bootstrap.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('backend/adminlte/dist/js/app.min.js') }}"></script>

@yield('custom-js')
</body>
</html>
