<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title }} | Admin Area - {{ config('app.company_name') }}</title>
        <link rel="icon" href="{{ config('app.favicon_file_path') }}">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/adminlte.min.css">
        <!-- Custom Styles -->
        @yield('styles')
    </head>
    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed @if(config('app.dark_mode')) dark-mode @endif">
        <div class="wrapper">
            <!-- Navbar -->
            @include('layouts.admin.nav')

            <!-- Main Sidebar Container -->
            @include('layouts.admin.sidebar')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                @include('layouts.admin.header')

                <!-- Main content -->
                <div class="content">
                    <div class="container-fluid">
                        @include('layouts.admin.alert')
                        @yield('content')
                    </div>
                </div>
            </div>

            <!-- Main Footer -->
            @include('layouts.client.footer')
        </div>

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/dist/js/adminlte.min.js"></script>
        <!-- overlayScrollbars -->
        <script src="/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

        <!-- PAGE PLUGINS -->
        <!-- jQuery Mapael -->
        <script src="/plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
        <script src="/plugins/raphael/raphael.min.js"></script>
        <script src="/plugins/jquery-mapael/jquery.mapael.min.js"></script>
        <script src="/plugins/jquery-mapael/maps/usa_states.min.js"></script>
        <!-- ChartJS -->
        <script src="/plugins/chart.js/Chart.min.js"></script>

        <!-- CUSTOM SCRIPTS -->
        @yield('scripts')
    </body>
</html>
