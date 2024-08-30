@extends( admin_module_layout('master') )
@section('title', 'Site Configurations')
@push('css')
    <style>


        .card {
            margin-bottom: 0rem;
        }
    </style>
@endpush
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>Site Configurations</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Setting</li>
        </ol>
    </div>
@endsection
@section('content')

    @php

        $tab = \Session::get('account-tab') ?: 'general';

        if( !isAdmin() )
        {
            $pers_tabs = [
                'setting.general'           => 'general',
                'setting.social.network'    => 'social-network',
                'setting.contact.support'   => 'contact-support',
                'setting.payment.gateway'   => 'payment-gateway',
                'setting.frontend.support'  => 'frontend-support',
                'setting.hospital.survey'   => 'hospital-survey',
                'setting.change.password'   => 'change-password',
            ];

            if( in_array(\Perms::$SETTING['GENERAL'], getAuth()->role_permissions) ) {
                $tab = $pers_tabs[\Perms::$SETTING['GENERAL']];
            }
            elseif( in_array(\Perms::$SETTING['SOCIAL_NETWORK'], getAuth()->role_permissions) ) {
                $tab = $pers_tabs[\Perms::$SETTING['SOCIAL_NETWORK']];
            }
            elseif( in_array(\Perms::$SETTING['PAYMENT_GATEWAY'], getAuth()->role_permissions) ) {
                $tab = $pers_tabs[\Perms::$SETTING['PAYMENT_GATEWAY']];
            }
            elseif( in_array(\Perms::$SETTING['FRONTEND_SUPPORT'], getAuth()->role_permissions) ) {
                $tab = $pers_tabs[\Perms::$SETTING['FRONTEND_SUPPORT']];
            }
            elseif( in_array(\Perms::$SETTING['HOSPITAL_SURVEY'], getAuth()->role_permissions) ) {
                $tab = $pers_tabs[\Perms::$SETTING['HOSPITAL_SURVEY']];
            }
            elseif( in_array(\Perms::$SETTING['CONTACT_SUPPORT'], getAuth()->role_permissions) ) {
                $tab = $pers_tabs[\Perms::$SETTING['CONTACT_SUPPORT']];
            }
            elseif( in_array(\Perms::$SETTING['CHANGE_PASSWORD'], getAuth()->role_permissions) ) {
                $tab = $pers_tabs[\Perms::$SETTING['CHANGE_PASSWORD']];
            }
        }
    @endphp

    @include( admin_module_layout('partials.simple-messages') )

    <div class="card">
        <div class="card-header p-2">
            <ul class="nav nav-pills">
                @if( isAdmin() || in_array(\Perms::$SETTING['GENERAL'], getAuth()->role_permissions) )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'general' ) active @endif" href="#general" data-toggle="tab"><i class="fas fa-cogs"></i> General</a>
                    </li>
                @endif
                @if( isAdmin() || in_array(\Perms::$SETTING['SOCIAL_NETWORK'], getAuth()->role_permissions) )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'social-network' ) active @endif" href="#social-network" data-toggle="tab"><i class="fas fa-share-alt"></i> Social Network</a>
                    </li>
                @endif
                @if( isAdmin() || in_array(\Perms::$SETTING['CONTACT_SUPPORT'], getAuth()->role_permissions) )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'contact-support' ) active @endif" href="#contact-support" data-toggle="tab"><i class="fas fa-question-circle"></i> Contact Support</a>
                    </li>
                @endif
                @if( isAdmin() || in_array(\Perms::$SETTING['COMPANY_ABOUT'], getAuth()->role_permissions) )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'frontend-support' ) active @endif" href="#frontend-support" data-toggle="tab"><i class="fas fa-question-circle"></i> Frontend Support</a>
                    </li>
                @endif
                @if( isAdmin() || in_array(\Perms::$SETTING['PAYMENT_GATEWAY'], getAuth()->role_permissions) )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'payment-gateway' ) active @endif" href="#payment-gateway" data-toggle="tab"><i class="fas fa-question-circle"></i> Payment Gateways</a>
                    </li>
                @endif
                @if( isAdmin() || in_array(\Perms::$SETTING['HOSPITAL_SURVEY'], getAuth()->role_permissions) )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'hospital-survey' ) active @endif" href="#hospital-survey" data-toggle="tab" style="display:none;"><i class="fas fa-question-circle"></i> Hospital Survey Jobs</a>
                    </li>
                @endif
                @if( isAdmin() || in_array(\Perms::$SETTING['CHANGE_PASSWORD'], getAuth()->role_permissions) )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'change-password' ) active @endif" href="#change-password" data-toggle="tab"><i class="fas fa-key"></i> Change Password</a>
                    </li>
                @endif
                @if( isAdmin())
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'announcements' ) active @endif" href="#announcements" data-toggle="tab"><i class="fas fa-bullhorn"></i> Announcement</a>
                    </li>
                @endif

                @if( isAdmin())
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'auth-setting' ) active @endif" href="#auth-setting" data-toggle="tab"><i class="fas fa-chalkboard-teacher"></i> Edit Profile</a>
                    </li>
                @endif

                @if( getAuth()->is_developer )
                    <li class="nav-item">
                        <a class="nav-link @if($tab == 'developer-option' ) active @endif" href="#developer-option" data-toggle="tab"><i class="fas fa-user-secret"></i> Developer Options</a>
                    </li>
                @endif
            </ul>
        </div>

        <div class="tab-content">

            <div class="@if($tab == 'general' ) active @endif tab-pane" id="general">
                @include( admin_module_render('tab-bucket.general') )
            </div>
            <div class="@if($tab == 'social-network' ) active @endif tab-pane" id="social-network">
                @include( admin_module_render('tab-bucket.social-network') )
            </div>
            <div class="@if($tab == 'contact-support' ) active @endif tab-pane" id="contact-support">
                @include( admin_module_render('tab-bucket.contact-support') )
            </div>
            <div class="@if($tab == 'payment-gateway' ) active @endif tab-pane" id="payment-gateway">
                @include( admin_module_render('tab-bucket.payment-gateways') )
            </div>
            <div class="@if($tab == 'frontend-support' ) active @endif tab-pane" id="frontend-support">
                @include( admin_module_render('tab-bucket.frontend-support') )
            </div>
            <div class="@if($tab == 'hospital-survey' ) active @endif tab-pane" id="hospital-survey">
                @include( admin_module_render('tab-bucket.hospital-survey') )
            </div>
            <div class="@if($tab == 'change-password' ) active @endif tab-pane" id="change-password">
                @include( admin_module_render('tab-bucket.change-password') )
            </div>
            <div class="@if($tab == 'auth-setting' ) active @endif tab-pane" id="auth-setting">
                @include( admin_module_render('tab-bucket.auth-setting') )
            </div>
            <div class="@if($tab == 'announcements' ) active @endif tab-pane" id="announcements">
                @include( admin_module_render('tab-bucket.announcement') )
            </div>

            @if( getAuth()->is_developer )
                <div class="@if($tab == 'developer-option' ) active @endif tab-pane" id="developer-option">
                    @include( admin_module_render('tab-bucket.developer-option') )
                </div>
            @endif
        </div>

    </div>

@stop

@push('scripts')

    <script>


        $('input[name="patient_category[]" ]').change(function () {
            if ($(this).is(':checked')) {
                $(this).closest('.row').find('.timezone select').prop('disabled', false);
                $(this).closest('.row').find('.schedule select').prop('disabled', false);
            } else {
                $(this).closest('.row').find('.timezone select').prop('disabled', true);
                $(this).closest('.row').find('.schedule select').prop('disabled', true);
            }
        })
        $('.day').hide();
        $('.time').hide();
        $('.schedule select').change(function () {
            var scheduleValue = $(this).val();
            if (scheduleValue == 'weeklyOn') {
                var lable = 'Week';
                var countDay = 7;
            } else if (scheduleValue == 'monthlyOn') {
                var lable = 'Day';
                var countDay = 30;

            } else if (scheduleValue == 'AfterMinute') {
                var lable = 'Minute';
                var countDay = 60;
            } else if (scheduleValue == 'Afterhourly') {
                var lable = 'Hours'
                var countDay = 24;
            }
            if (scheduleValue == 'weeklyOn' || scheduleValue == 'monthlyOn' || scheduleValue == 'AfterMinute' || scheduleValue == 'Afterhourly') {
                $(this).closest('.row').find('.day').show();
                if ($(this).closest('.row').find('input[name="patient_category[]" ]').is(':disabled')) {
                    $(this).closest('.row').find('.day select').prop('disabled', true);
                } else {
                    $(this).closest('.row').find('.day select').prop('disabled', false);

                }

                $(this).closest('.row').find('.day label').html(lable);
                var option = '<option value="">Select Day</option>';
                for (var i = 1; i <= countDay; i++) {
                    option += '<option value="' + i + '">' + i + '</option>';
                }
                $(this).closest('.row').find('.day select').html(option);
            } else {
                $(this).closest('.row').find('.day').hide();
                $(this).closest('.row').find('.day select').prop('disabled', true);
            }

            if (scheduleValue == 'dailyAt' || scheduleValue == 'weeklyOn' || scheduleValue == 'monthlyOn') {
                $(this).closest('.row').find('.time').show();
                if ($(this).closest('.row').find('input[name="patient_category[]" ]').is(':disabled')) {

                    $(this).closest('.row').find('.time input').prop('disabled', true);
                } else {
                    $(this).closest('.row').find('.time input').prop('disabled', false);
                }
            } else {
                $(this).closest('.row').find('.time').hide();
                $(this).closest('.row').find('.time input').prop('disabled', true);
            }
        });

        $(document).ready(function () {

            $('.time_zone').select2();

            $(".time_zone_general_hospital").val("{{ScheduleDetails('GENERAL_HOSPITAL')->timezone??''}}").change();
            $(".schedule_general_hospital").val("{{ScheduleDetails('GENERAL_HOSPITAL')->schedule??''}}").change();
            $(".day_general_hospital").val("{{ScheduleDetails('GENERAL_HOSPITAL')->day??''}}").change();

            // hospital

            $(".time_zone_hospital_infection").val("{{ScheduleDetails('HOSPITAl','INFECTION')->timezone??''}}").change();
            $(".schedule_hospital_infection").val("{{ScheduleDetails('HOSPITAl','INFECTION')->schedule??''}}").change();
            $(".day_hospital_infection").val("{{ScheduleDetails('HOSPITAl','INFECTION')->day??''}}").change();

            $(".time_zone_hospital_survey").val("{{ScheduleDetails('HOSPITAl','SURVEY')->timezone??''}}").change();
            $(".schedule_hospital_survey").val("{{ScheduleDetails('HOSPITAl','SURVEY')->schedule??''}}").change();
            $(".day_hospital_survey").val("{{ScheduleDetails('HOSPITAl','SURVEY')->day??''}}").change();

            $(".time_zone_hospital_death_and_complication").val("{{ScheduleDetails('HOSPITAl','COMPLICATION_AND_DEATH')->timezone??''}}").change();
            $(".schedule_hospital_death_and_complication").val("{{ScheduleDetails('HOSPITAl','COMPLICATION_AND_DEATH')->schedule??''}}").change();
            $(".day_hospital_death_and_complication").val("{{ScheduleDetails('HOSPITAl','COMPLICATION_AND_DEATH')->day??''}}").change();

            $(".time_zone_hospital_unplanned_visits").val("{{ScheduleDetails('HOSPITAl','UNPLANNED_VISITS')->timezone??''}}").change();
            $(".schedule_hospital_unplanned_visits").val("{{ScheduleDetails('HOSPITAl','UNPLANNED_VISITS')->schedule??''}}").change();
            $(".day_hospital_unplanned_visits").val("{{ScheduleDetails('HOSPITAl','UNPLANNED_VISITS')->day??''}}").change();

            $(".time_zone_hospital_timely_and_effective").val("{{ScheduleDetails('HOSPITAl','TIMELY_AND_EFFECTIVE')->timezone??''}}").change();
            $(".schedule_hospital_timely_and_effective").val("{{ScheduleDetails('HOSPITAl','TIMELY_AND_EFFECTIVE')->schedule??''}}").change();
            $(".day_hospital_timely_and_effective").val("{{ScheduleDetails('HOSPITAl','TIMELY_AND_EFFECTIVE')->day??''}}").change();

            //national
            $(".time_zone_national_infection").val("{{ScheduleDetails('NATIONAL','INFECTION')->timezone??''}}").change();
            $(".schedule_national_infection").val("{{ScheduleDetails('NATIONAL','INFECTION')->schedule??''}}").change();
            $(".day_national_infection").val("{{ScheduleDetails('NATIONAL','INFECTION')->day??''}}").change();

            $(".time_zone_national_survey").val("{{ScheduleDetails('NATIONAL','SURVEY')->timezone??''}}").change();
            $(".schedule_national_survey").val("{{ScheduleDetails('NATIONAL','SURVEY')->schedule??''}}").change();
            $(".day_national_survey").val("{{ScheduleDetails('NATIONAL','SURVEY')->day??''}}").change();

            $(".time_zone_national_survey_cancer").val("{{ScheduleDetails('NATIONAL','SURVEY_CANCER')->timezone??''}}").change();
            $(".schedule_national_survey_cancer").val("{{ScheduleDetails('NATIONAL','SURVEY_CANCER')->schedule??''}}").change();
            $(".day_national_survey_cancer").val("{{ScheduleDetails('NATIONAL','SURVEY_CANCER')->day??''}}").change();

            $(".time_zone_national_death_and_complication").val("{{ScheduleDetails('NATIONAL','COMPLICATION_AND_DEATH')->timezone??''}}").change();
            $(".schedule_national_death_and_complication").val("{{ScheduleDetails('NATIONAL','COMPLICATION_AND_DEATH')->schedule??''}}").change();
            $(".day_national_death_and_complication").val("{{ScheduleDetails('NATIONAL','COMPLICATION_AND_DEATH')->day??''}}").change();

            $(".time_zone_national_unplanned_visits").val("{{ScheduleDetails('NATIONAL','UNPLANNED_VISITS')->timezone??''}}").change();
            $(".schedule_national_unplanned_visits").val("{{ScheduleDetails('NATIONAL','UNPLANNED_VISITS')->schedule??''}}").change();
            $(".day_national_unplanned_visits").val("{{ScheduleDetails('NATIONAL','UNPLANNED_VISITS')->day??''}}").change();

            $(".time_zone_national_timely_and_effective").val("{{ScheduleDetails('NATIONAL','TIMELY_AND_EFFECTIVE')->timezone??''}}").change();
            $(".schedule_national_timely_and_effective").val("{{ScheduleDetails('NATIONAL','TIMELY_AND_EFFECTIVE')->schedule??''}}").change();
            $(".day_national_timely_and_effective").val("{{ScheduleDetails('NATIONAL','TIMELY_AND_EFFECTIVE')->day??''}}").change();
            $('input[name="patient_category[]" ]').each(function () {
                if (!$(this).is(':disabled')) {
                    if ($(this).is(':checked')) {
                        $(this).closest('.row').find('select').prop('disabled', false);
                        $(this).closest('.row').find('input').prop('disabled', false);
                    } else {
                        $(this).closest('.row').find(' select').prop('disabled', true);
                        $(this).closest('.row').find(' input').prop('disabled', true);
                    }
                }
            });

        });


    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function () {
            if ($('#frontend_video_box_2_youtube').is(":checked")) {
                $('.frontend_video_box_2_youtube').show();
                $('.frontend_video_box_2_upload').hide();
            }
            if ($('#frontend_video_box_2_upload').is(":checked")) {
                $('.frontend_video_box_2_youtube').hide();
                $('.frontend_video_box_2_upload').show();
            }
            $(document).on("click", '#frontend_video_box_2_youtube', function () {
                $('.frontend_video_box_2_youtube').show();
                $('.frontend_video_box_2_upload').hide();
            });
            $(document).on("click", '#frontend_video_box_2_upload', function () {
                $('.frontend_video_box_2_youtube').hide();
                $('.frontend_video_box_2_upload').show();
            })
            if ($('#frontend_video_box_1_youtube').is(":checked")) {
                $('.frontend_video_box_1_youtube').show();
                $('.frontend_video_box_1_upload').hide();
            }
            if ($('#frontend_video_box_1_upload').is(":checked")) {
                $('.frontend_video_box_1_youtube').hide();
                $('.frontend_video_box_1_upload').show();
            }
            $(document).on("click", '#frontend_video_box_1_youtube', function () {
                $('.frontend_video_box_1_youtube').show();
                $('.frontend_video_box_1_upload').hide();
            });
            $(document).on("click", '#frontend_video_box_1_upload', function () {
                $('.frontend_video_box_1_youtube').hide();
                $('.frontend_video_box_1_upload').show();
            })
            $(document).on("click", '#video_remove_1', function () {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this video file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $('.video_remove_1').val(1);
                            $('#frame_video_remove_1').hide();
                        } else {
                            swal("Your video is safe!");
                        }
                    });


            })
            $(document).on("click", '#video_remove_2', function () {
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this video file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                    .then((willDelete) => {
                        if (willDelete) {
                            $('.video_remove_2').val(1);
                            $('#frame_video_remove_2').hide();
                        } else {
                            swal("Your video is safe!");
                        }
                    });


            })
        })


    </script>
@endpush


