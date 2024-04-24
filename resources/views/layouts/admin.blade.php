<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="x icon" type="img/png" href="/images/CvSU-logo-16x16.webp">
    <title>
      @yield('title') &sdot; {{ config('app.name') }}
    </title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Sweet Alert 2 -->
    <link rel="stylesheet" href="{{asset('plugins/sweetalert2/sweetalert2.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
    <!-- Chart JS -->
    <link rel="stylesheet" href="{{asset('plugins/chart.js/Chart.css')}}">
    <!-- Bootstrap Iconpicker CSS-->
    <link rel="stylesheet" href="{{asset('plugins/fontawesome-iconpicker/css/bootstrap-iconpicker.css')}}"/>
  </head>
  <body class="hold-transition sidebar-mini">
    <!-- Preloader -->
		<div class="preloader flex-column justify-content-center align-items-center">
			<img class="animation__shake" src="/images/CvSU-logo-64x64.webp" alt="CvSU Logo" height="60" width="60">
		</div>
    <div class="wrapper">
      <!-- Navbar -->
      @include('partials.navbar')
      <!-- /.navbar -->

      <!-- Main Sidebar Container -->
      @include('partials.sidebar')

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        
        @yield('main-content-header')
        <!-- /.content-header -->

        <!-- Main content -->
        @yield('main-content')
        <!-- /.content -->
        </div>
      <!-- /.content-wrapper -->

      <!-- Control Sidebar -->
      @include('partials.aside')
      <!-- /.control-sidebar -->

      <!-- Main Footer -->
      @include('partials.footer')
    </div>
    <!-- ./wrapper -->
  </body>
  <!-- REQUIRED SCRIPTS -->
  <!-- jQuery -->
  <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <!-- Sweet Alert 2 -->
  <script src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
  <!-- AdminLTE App -->
  <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
  <!-- Sweet Alert 2 -->
  <script src="{{asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>
  <!-- Chart JS -->
  <script src="{{asset('plugins/chart.js/Chart.js')}}"></script>
  <!-- Bootstrap Iconpicker JS -->
  <script src="{{asset('plugins/fontawesome-iconpicker/js/bootstrap-iconpicker.bundle.min.js')}}"></script>
  @yield('script')
</html>