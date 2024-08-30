<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $site_settings['sites']['site_name'] ?? 'No Title' }} | @yield('title') </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ admin_asset('/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('/dist/css/intlTelInput.css') }}">
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ admin_asset('/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ admin_asset('/dist/css/auth.css?v=' . rand() ) }}">
    @stack('css')
</head>

<body class="hold-transition login-page" style="background: url({{ asset('images/login-background.jpg') }}) no-repeat; background-size: cover; background-position: bottom; ">

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

    @yield('content')

    <!-- jQuery -->
    <script src="{{ admin_asset('/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ admin_asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ admin_asset('/dist/js/adminlte.min.js') }}"></script>
    <script src="{{ admin_asset('/dist/js/intlTelInput.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ admin_asset('/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function(){

            $loading = $('#const-spinner');
            $loading.hide();

            $("form").on('submit', function(){

                $loading.show();

                setTimeout(function(){
                    return true;
                }, 1000)
            });

            $(document)
            .ajaxStart(function () {
                $loading.show();
            })
            .ajaxStop(function () {
                $loading.hide();
            });

            //Initialize Select2 Elements
            $('.select2').select2();

            let buildarea = function(){
                $("body").focusout(function () {
                    $.each($('form').find('.input-group, .form-group '), function (index, value) {
                        if ($(value).find('input, textarea').val() == "" ) {
                            $(value).removeClass('float');
                        }
                    });
                });
            }

            $(".abs-float, input, textarea, .form-group ").on('click', function(){
                buildarea();
                $(this).parent('.input-group, .form-group').addClass('float');
            });

            $(".abs-float, input, textarea, .form-group ").on('focus', function(){
                buildarea();
                $(this).parent('.input-group, .form-group').addClass('float');
            });

            $('.const-categories, .const-businesses').select2().on('select2:open', (elm) => {
                const targetLabel = $(elm.target).prev('label');
                targetLabel.addClass('selected');
            }).on('select2:close', (elm) => {
                const target = $(elm.target);
                const targetLabel = target.prev('label');
                const targetOptions = $(elm.target.selectedOptions);
                if (targetOptions.length === 0) {
                    targetLabel.removeClass('selected');
                }
            });
        })
    </script>

    @stack('scripts')
</body>
</html>
