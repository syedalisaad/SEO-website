@extends( admin_layout('auth') )
@section('title', 'Register')
@push('css')
    <style>
        .register-box {
            width: 40%;
        }

        .form-group .iti.iti--allow-dropdown.iti--separate-dial-code { width: 100%; }
        .form-group span.select2 { width: 100%; }
        .select2-container--default .select2-selection--multiple { border: solid #d4d9df 1px; }
        .select2-container--default .select2-selection--multiple .select2-selection__choice{ background-color: #aa5ae2; border: 1px solid #a75ae2;}
        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove { color: #fff; }
        .select2-container--default.select2-container--focus .select2-selection--multiple{ border: solid #80bdff 1px; }

        form.verification-form .form-group {
            position: relative;
            width: 60%;
            margin: auto;
        }
        form.verification-form input {
            width: 100%;
            margin: auto;
            padding: 18px !important;
        }

        @media screen and (min-width: 100px) and (max-width: 900px) {
            .register-box {
                width: auto;
                margin: 0 15px;
            }

            form.verification-form input {
                width: 100%;
                margin: auto;
            }

            .nav-tabs .nav-item a {
                font-size: 15px;
            }
        }

        @media screen and (min-width: 100px) and (max-width: 500px) {
            .nav-tabs .nav-item a {
                font-size: 11px;
            }
        }
    </style>
@endpush
@section('content')

    @php $tab = (\Session::get('active-tab') ?: $active_tab);@endphp

    <div class="register-box">

        <div class="login-logo">
            <a href="{{ url('/') }}">
                <img src="{{ ($site_settings['sites']['site_logo'] ? media_storage_url( $site_settings['sites']['site_logo']) : asset('images/logo.png')) }}" class="img-fluid" alt="{{ $site_settings['sites']['site_name'] ?? null }}"/>
            </a>
        </div>

        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'signup-info' ? 'active' : 'disabled' }}" id="signup-info" data-toggle="pill" href="#signup-info-tab" role="tab" aria-controls="signup-info-tab" aria-selected="true">Sign Up</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'verification-process' ? 'active' : 'disabled' }}" id="verification-process" data-toggle="pill" href="#verification-process-tab" role="tab" aria-controls="verification-process-tab" aria-selected="false">Verification Process</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ $tab == 'get-started' ? 'active' : 'disabled' }}" id="get-started" data-toggle="pill" href="#get-started-tab" role="tab" aria-controls="get-started-tab" aria-selected="false">Get Started</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-one-tabContent">

                    <div class="tab-pane fade {{ $tab == 'signup-info' ? 'show active' : '' }}" id="signup-info-tab" role="tabpanel" aria-labelledby="signup-info">

                        <form role="form" action="{{ route(admin_route('register')) }}" method="POST">
                            @csrf
                            @include( admin_view('auth.signup.register-form'), ['type_of' => get_current_slug() ] )
                            <div class="row mt-3 mb-0">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <button type="submit" class="btn col-md-6 btn-primary">Register</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-3 mb-0">
                                <div class="col-6">
                                    <a href="{{ route( admin_route('login') ) }}" class="float-left">Already Registered ? Sign In</a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ url('/') }}" class="float-right">Cancel</a>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="tab-pane fade {{ $tab == 'verification-process' ? 'show active' : '' }}" id="verification-process-tab" role="tabpanel" aria-labelledby="verification-process">
                        @if( isset($userdata) && $userdata )
                            <form role="form" class="verification-form" action="{{ route(admin_route('verifyemail'), [ $userdata->id ]) }}" method="POST">
                                @csrf
                                <div class="text-center mt-5 mb-5"><i class="fas fa-mobile-alt fa-8x"></i></div>
                                <p class="text-muted text-center const-try-again">
                                    A Verification code SMS has been sent to the registered number <strong>{{ $userdata->phone }}</strong>
                                </p>
                                @include( admin_view('auth.signup.OPT-form') )
                                <p class="text-muted text-center mt-0 mb-5">
                                    <u><a href="javascript:void(0)" class="const-resent-verifycode">Resend OTP</a></u>
                                </p>
                                <div class="row mt-3 mb-0">
                                    <div class="col-md-12">
                                        <div class="text-center">
                                            <button type="submit" class="btn col-md-6 btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        @endif
                    </div>

                    <div class="tab-pane fade {{ $tab == 'get-started' ? 'active show' : '' }}" id="get-started-tab" role="tabpanel" aria-labelledby="get-started">

                        @if( isset($userdata) && $userdata )
                            <div class="text-center mt-4 mb-4"><i class="fas fa-hands-helping fa-8x"></i></div>
                            <h3 class="text-muted text-center">Hi, {{ $userdata->full_name }}</h3> <br>
                            <h5 class="text-muted text-center">Congratulations, now you are a member of <strong>{{ $site_settings['sites']['site_name'] ?? 'Site Name' }}</strong>!</h5>

                            @if( get_current_slug() == 'buyer' )
                                <h5 class="text-muted text-center">You have been successfully registered.</h5><br>
                                <p class="text-muted text-center">Redirect to <a href="{{ route( admin_route('login')) }}" class="const-redirect-page">log in</a> page after 5 seconds. If you're not redirect, <br>Please click below </p>
                            @else
                                <h5 class="text-muted text-center">Your registration has been submitted for review</h5><br>
                                <p class="text-muted text-center">
                                    Once approved, you will be notified via email with your login instructions. <br>
                                        Please, feel free to <a href="{{ route( 'front.page.contact') }}">contact us</a> with any questions.<br/>
                                    Please do not attempt to login until you have reviced further instructions.
                                </p>
                                <p class="text-muted text-center">Redirect to <a href="{{ route( 'front.home') }}" class="const-redirect-page">homepage</a> page after 5 seconds. If you're not redirect, <br>Please click below </p>
                            @endif
                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <div class="text-center">
                                        <a href="{{ route( admin_route('verifystartednow'), [$userdata->remember_token]) }}" class="btn col-md-6 btn-primary pace-progress-color-white" style="color:white">Get Started</a>
                                    </div>
                                </div>
                            </div><br/>
                        @endif
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@push('scripts')
    <script>
        $(function () {
            //Initialize Select2 Elements
            @if( isset($userdata) && $userdata )
            $('.const-resent-verifycode').on('click', function(){

                let data    = { _token: "{{ csrf_token() }}"};
                let api_url = ('{{ route(admin_route('resentverifycode'), [ $userdata->id ]) }}');

                $.post(api_url, data).done(function( response ){

                    if( response.status == true ) {
                        $(".const-try-again").html( response.message );
                    }
                });
            });
            @endif

            @if( $tab == 'get-started' )
            setTimeout(function(){
               window.location = $(".const-redirect-page").attr('href');
            }, 5000);
            @endif
        })
    </script>
@endpush
