<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
      @if(View::hasSection('title'))
        @yield('title')
      @else
      {{ config('app.name', 'Laravel') }}
      @endif
    </title>
    <!-- Font Awesome -->
    {{-- <link rel="stylesheet" href="{{ asset('assets/admin/plugins/fontawesome-free/css/all.min.css') }}"> --}}
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css" integrity="sha512-q3eWabyZPc1XTCmF+8/LuE1ozpg5xxn7iO89yfSOd5/oKvyqLngoNGsx8jq92Y8eXJ/IRxQbEC+FGSYxtk2oiw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- Ionicons -->
  <link rel="stylesheet" href="//code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/select2/css/select2.min.css') }}">
  <!-- adminlte -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/adminlte.min.css') }}">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="{{ asset('assets/admin/css/style.css') }}">
  <link rel="stylesheet" href="{{asset('assets/loading.css')}}" />
  @yield('css')
    <!-- Scripts -->
    <script src="{{ asset('assets/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="//code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
</head>
<body class="hold-transition sidebar-mini layout-fixed">

    <!-- Site wrapper -->
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>
    <h4 class="text-center m-0 p-0">{{ session('branch')['name'] ?? '' }}</h4>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="fab fa-accessible-icon"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"></span>
          <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Logout') }}
          </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.layouts.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if(View::hasSection('title'))
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>@yield('title')</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">@yield('title')</li>
            </ol>
            </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
    @endif

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @yield('content')
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer  no-print">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.0.5
    </div>
    <strong>Developed By <a href="//pondit.com">Pondit.com</a>.</strong>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@yield('print')

    <!-- Bootstrap 4 -->
    <script src="{{ asset('assets/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('assets/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('assets/admin/plugins/select2/js/select2.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('assets/admin/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for ddashboard -->
    {{-- <script src="{{ asset('assets/admin/js/pages/dashboard.js') }}"></script> --}}
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('assets/admin/js/demo.js') }}"></script>
    @yield('js')
    @yield('js2')
    @stack('scripts')
<script>
(function($) {
    $(document).ready(function() {
      'use strict'
        $(document).ready(function() {
            $('.select2').select2();
            $('.select2-multi').select2();         //{ width: '300px' }
        });
      });
})(jQuery);
    </script>
</body>
</html>
