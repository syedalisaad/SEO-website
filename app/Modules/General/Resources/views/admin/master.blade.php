<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ $site_settings['sites']['site_name'] ?? 'No Title' }} | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ route(admin_route('dashboard')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @if( isset($site_settings['sites']) && $site_settings['sites']['site_favicon'] )
        <link rel="icon" href="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_favicon']) ?: front_asset('images/fav.png')) }}" type="image/gif">
    @endif

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Bootstrap4 Duallistbox -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_asset('/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('/dist/css/custom.css?v=' . rand()) }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <!-- summernote -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/summernote/summernote-bs4.css') }}" />

    @stack('css')
</head>
<body class="sidebar-mini layout-fixed text-sm">

    <div class="loading const-spinner" id="const-spinner">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto;background: rgb(0 0 0);display: block;shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <circle cx="50" cy="50" r="0" fill="none" stroke="#6356e6" stroke-width="2">
                <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.5s"/>
                <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.5s"/>
            </circle>
            <circle cx="50" cy="50" r="0" fill="none" stroke="#cb5ce0" stroke-width="2">
                <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline"/>
                <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline"/>
            </circle>
        </svg>
    </div>

    <!-- Site wrapper -->
    <div class="wrapper">
      <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">

            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route( admin_route('dashboard')) }}" class="nav-link">Dashboard</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:void(0)">
                        {{ date('F d, Y') }} {{ date('h:i a', strtotime("now")) }}
                    </a>
                </li>
                @include( admin_module_view('partials.settings') )
            </ul>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">

            @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
                <a class="brand-link text-center" href="{{ url('/') }}" style="background: #fff">
                    <img class="img-fluid" src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: front_asset('images/logo.png')) }}" alt="{{ $site_settings['sites']['site_name'] }}" width="70%"/>
                </a>
            @endif

            <!-- Sidebar -->
            @include( admin_module_view('partials.sidebar') )
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        @yield('breadcrumbs')
                    </div>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                @yield('content')
            </section>

        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block"><b>Version</b>: {{ $site_settings['developers']['version'] ?? '1.0.0'}}</div>
            <strong>
                Copyright &copy; 2021-{{ date('Y') }}.
            </strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        </aside>

    </div>

    @stack('modals')

    <!-- jQuery -->
    <script src="{{ admin_asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ admin_asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- overlayScrollbars -->
    <script src="{{ admin_asset('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ admin_asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="{{ admin_asset('/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ admin_asset('/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ admin_asset('/plugins/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ admin_asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- bootstrap color picker -->
    <script src="{{ admin_asset('/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ admin_asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- Bootstrap Switch -->
    <script src="{{ admin_asset('/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ admin_asset('/dist/js/adminlte.min.js') }}"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="{{ admin_asset('/dist/js/demo.js') }}"></script>

    <script src="{{ admin_asset('/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>

    <!-- AdminLTE for Dev Utils -->
    <script src="{{ admin_asset('/js/utils.js?v=' . rand()) }}"></script>

    <script type="text/javascript">
    $(document).ready(function () {

        bsCustomFileInput.init();

        $('[data-toggle="tooltip"]').tooltip();

        $(document).on('click', '.const-del-records', function () {

            if (confirm('Are you sure you want to remove?')) {
                window.location = $(this).data('href');
            }

            return false;
        });

        $(document).on('click', '.const-confirm-records', function () {

            let title = $(this).data('title')||'Are you sure you want to continue?';

            if (confirm(title)) {
                window.location = $(this).data('href');
            }

            return false;
        });

        function formatPhoneNumber(phoneNumberString) {
            var cleaned = ('' + phoneNumberString).replace(/\D/g, '');
            var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
            if (match) {
                return '+1 (' + match[1] + ') ' + match[2] + '-' + match[3];
            }
            return null;
        }
    });
    </script>

    @stack('scripts')
</body>
</html>
