<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('assets/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/adminlte.min.css')}}">
</head>
<body class="hold-transition">
    <div class="row">
      <div class="col-md-6 d-none d-md-block">
        <img src="{{ asset('upload/site_file/'.config('settings.appBanner')) }}" alt="" class="img-fluid">
      </div>
      <div class="col-12 col-md-6">
        <div class="login-logo mt-3">
          {{-- <a href="{{ url('/') }}">{{ config('app.name', 'Laravel') }}</a> --}}
          <img src="{{ asset('upload/site_file/'.config('settings.appLogo')) }}" alt="{{ config('app.name', 'Laravel') }}" class="" style="max-height: 50px">
        </div>
        <!-- /.login-logo -->
        <div class="card m-3">
          <div class="card-body login-card-body">
            {{ $slot }}
        </div>
        <!-- /.login-card-body -->
        </div>
      </div>
  </div>
    <!-- jQuery -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/js/adminlte.min.js')}}"></script>
</body>
</html>