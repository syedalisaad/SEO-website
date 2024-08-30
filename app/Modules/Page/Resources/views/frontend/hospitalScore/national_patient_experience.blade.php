@extends( front_layout('master') )
@section('title', $page_title)
@section('content')
@section('meta_tags')
    <meta property="url" content="{{ route(front_route('page.national.survey')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $page_title }}" />
    <meta property="og:url" content="{{ route(front_route('page.national.survey')) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $page_title }}" />
    @php $site_settings = get_site_settings(); @endphp
    @if( isset($site_settings['sites']) && isset($site_settings['sites']['share_logo']) )
        <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image:url" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image:width" content="400"/>
        <meta property="og:image:height" content="300"/>
        <meta name="twitter:image:src" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta name="twitter:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
    @endif
@endsection
    <div class="unsubscribe infection">
        <div class="custom-container">

            <div class="row listings">
                <div class="col-md-9">
                    <h2>National Patient Experience</h2>

                    <div class="img">
                        <img src="{{asset(front_asset('images/single-patience.webp'))}}" alt="single-infection">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="share">
                        <a href="javascript:void(0)"><i class="fas fa-share-square"></i> Share this Hospital</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="national_date">
                        <li class="white fourcolumn">
                            <h4>Nurse Communication Experience</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Nurses Communicated well?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_COMP_1_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_COMP_1_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_COMP_1_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Nurses "always" Communicated well</li>
                                            <li>Nurses "sometimes" or "never" Communicated well</li>
                                            <li>Nurses "usually" Communicated well</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Nurses treated them with courtesy and respect?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_NURSE_RESPECT_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_NURSE_RESPECT_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_NURSE_RESPECT_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Nurses "always" treated them with courtesy and respect</li>
                                            <li>Nurses "sometimes" or "never" treated them with courtesy and respect</li>
                                            <li>Nurses "usually" treated them with courtesy and respect</li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Nurses listened carefully?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_NURSE_LISTEN_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_NURSE_LISTEN_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_NURSE_LISTEN_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Nurses "always" listened carefully</li>
                                            <li>Nurses "sometimes" or "never" listened carefully</li>
                                            <li>Nurses "usually" listened carefully</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Nurses explained things so they could understand?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_NURSE_EXPLAIN_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_NURSE_EXPLAIN_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_NURSE_EXPLAIN_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Nurses "always" explained things so they could understand</li>
                                            <li>Nurses "sometimes" or "never" explained things so they could understand</li>
                                            <li>Nurses "usually" explained things so they could understand</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured Dates:</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_1_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}} </br> to </br> {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_1_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white fourcolumn">

                            <h4>Doctor Communication Experience</h4>
                            <div class="boxes">
                                <div class="inner-box">

                                    <div class="pie-chart">
                                        <h5>Doctors Communicated well?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_COMP_2_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_COMP_2_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_COMP_2_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Doctors "always" Communicated well</li>
                                            <li>Doctors "sometimes" or "never" Communicated well</li>
                                            <li>Doctors "usually" Communicated well</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Doctors treated them with courtesy and respect?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_DOCTOR_RESPECT_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_DOCTOR_RESPECT_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_DOCTOR_RESPECT_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Doctors "always" treated them with courtesy and respect</li>
                                            <li>Doctors "sometimes" or "never" treated them with courtesy and respect</li>
                                            <li>Doctors "usually" treated them with courtesy and respect</li>
                                        </ul>
                                    </div>

                                </div>
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Doctors listen carefully?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_DOCTOR_LISTEN_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_DOCTOR_LISTEN_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_DOCTOR_LISTEN_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Doctors "always" listen carefully</li>
                                            <li>Doctors "sometimes" or "never" listen carefully</li>
                                            <li>Doctors "usually" listen carefully</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Doctors explained things so they could understand?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_DOCTOR_EXPLAIN_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_DOCTOR_EXPLAIN_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_DOCTOR_EXPLAIN_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Doctors "always" explained things so they could understand</li>
                                            <li>Doctors "sometimes" or "never" explained things so they could understand</li>
                                            <li>Doctors "usually" explained things so they could understand</li>
                                        </ul>
                                    </div>

                                </div>

                                <div class="inner-box">
                                    <h5>Measured Dates:</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_2_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}}</br> to </br>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_2_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white fourcolumn">
                            <h4>Patient Experience with Assistance</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Patients received call button help as soon as they wanted?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_CALL_BUTTON_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_CALL_BUTTON_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_CALL_BUTTON_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Patients "always" received call button help as soon as they wanted</li>
                                            <li>Patients "sometimes" or "never" received call button help as soon as they wanted</li>
                                            <li>Patients "usually" received call button help as soon as they wanted</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Patients received bathroom help as soon as they wanted?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_BATH_HELP_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_BATH_HELP_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_BATH_HELP_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Patients "always" received bathroom help as soon as they wanted</li>
                                            <li>Patients "sometimes" or "never" received bathroom help as soon as they wanted</li>
                                            <li>Patients "usually" received bathroom help as soon as they wanted</li>
                                        </ul>
                                    </div>


                                </div>
                                <div class="inner-box">

                                    <div class="pie-chart">
                                        <h5>Patients received help as soon as they wanted?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_COMP_3_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_COMP_3_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_COMP_3_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Patients "always" received help as soon as they wanted</li>
                                            <li>Patients "sometimes" or "never" received help as soon as they wanted</li>
                                            <li>Patients "usually" received help as soon as they wanted</li>
                                        </ul>
                                    </div>

                                </div>


                                <div class="inner-box">
                                    <h5>Measured Dates:</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_CALL_BUTTON_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}}</br> to </br>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_CALL_BUTTON_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_CALL_BUTTON_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}} </br> to </br> {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_CALL_BUTTON_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>

                        <li class="white fourcolumn">

                            <h4>Patient Experience With Medication</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Staff explained new medications?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_MED_FOR_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_MED_FOR_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_MED_FOR_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Staff "always" explained new medications</li>
                                            <li>Staff "sometimes" or "never" explained new medications</li>
                                            <li>Staff "usually" explained new medications</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Staff explained possible side effects?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_SIDE_EFFECTS_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_SIDE_EFFECTS_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_SIDE_EFFECTS_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Staff "always" explained possible side effects</li>
                                            <li>Staff "sometimes" or "never" explained possible side effects</li>
                                            <li>Staff "usually" explained possible side effects</li>
                                        </ul>
                                    </div>


                                </div>
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Staff explained about medicines before giving them?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_COMP_5_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_COMP_5_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_COMP_5_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Staff "always" explained</li>
                                            <li>Staff "sometimes" or "never" explained</li>
                                            <li>Staff "usually" explained</li>
                                        </ul>
                                    </div>

                                </div>


                                <div class="inner-box">
                                    <h5>Measured Dates:</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_MED_FOR_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}}</br> to </br>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_MED_FOR_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_MED_FOR_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}} </br> to </br> {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_MED_FOR_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>


                        <li class="white fourcolumn">
                            <h4>Patient Discharge and Care Transition</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Patients reported they were given information about what to do during their recovery at home?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_COMP_6_Y_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="0" data-usually="{{NationalScoreDetails('NATIONAL','H_COMP_6_N_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>yes, staff "did" give patients this information</li>
                                            <li>No, staff "did not" give patients this information</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Patients reported they did discuss whether they would need help after discharge?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_DISCH_HELP_Y_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="0" data-usually="{{NationalScoreDetails('NATIONAL','H_DISCH_HELP_N_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Yes, staff "did" give patients information about help after discharge</li>
                                            <li>No, staff "did not" give patients information about help after discharge</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Patients reported they did receive written information about possible symptoms to look out for after discharge?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_SYMPTOMS_Y_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="0" data-usually="{{NationalScoreDetails('NATIONAL','H_SYMPTOMS_N_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Yes, staff "did" give patients information about possible symptoms</li>
                                            <li>No, staff "did not" give patients information about possible symptoms</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Patients understood their care when they left the hospital?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_COMP_7_SA','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_COMP_7_A','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_COMP_7_D_SD','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Patients who "Strongly Agree" they understood their care when they left the hospital</li>
                                            <li>Patients who "Disagree" or "strongly Disagree" they understood their care when they left the hospital</li>
                                            <li>Patients who "Agree" they understood their care when they left the hospital</li>
                                        </ul>
                                    </div>

                                </div>

                                <div class="inner-box">

                                    <div class="pie-chart">
                                        <h5>Patients felt the staff took my preferences into account when determining their health care needs?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_CT_PREFER_SA','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_CT_PREFER_A','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_CT_PREFER_D_SD','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Patients who "Strongly Agree" that staff took their preferences into account</li>
                                            <li>Patients who "Disagree" or "strongly Disagree" that staff took their preferences into account</li>
                                            <li>Patients who "Agree" that staff took their preferences into account</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <div class="pie-chart">
                                            <h5>Patients understood their responsiblities in managing their health?</h5>
                                            <p>
                                                <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_CT_UNDER_SA','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_CT_UNDER_A','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_CT_UNDER_D_SD','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                            </p>
                                            <ul class="chartline">
                                                <li>Patients who "strongly Agree" they understood their responsiblities when they left the hospital</li>
                                                <li>Patients who "Disagree" or "strongly Disagree" they understood their responsiblities when they left the hospital</li>
                                                <li>Patients who "Agree" they understood their responsiblities when they left the hospital</li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Patient understood the purposes of their medicines when leaving the hospital?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_CT_MED_SA','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_CT_MED_A','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_CT_MED_D_SD','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Patients who "Strongly Agree" they understood their medicines when they left the hospital</li>
                                            <li>Patients who "Disagree" or "strongly Disagree" they understood their medicines when they left the hospital</li>
                                            <li>Patients who "Agree" they understood their medicines when they left the hospital</li>
                                        </ul>
                                    </div>


                                </div>


                                <div class="inner-box">
                                    <h5>Measured Dates:</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_6_Y_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}} </br> to </br> {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_6_Y_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_6_Y_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}}  </br> to </br> {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_6_Y_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>


                        <li class="white fourcolumn">
                            <h4>Patient Perception of the Hospital</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Patients reported their room and bathroom were clean?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_CLEAN_HSP_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_CLEAN_HSP_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_CLEAN_HSP_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Room "always" clean</li>
                                            <li>Room "sometimes" or "never" clean</li>
                                            <li>Room "usually" clean</li>
                                        </ul>
                                    </div>

                                    <div class="pie-chart">
                                        <h5>Patients reported the area around their room was quiet at night?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_QUIET_HSP_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_QUIET_HSP_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_QUIET_HSP_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>"always" quiet at night</li>
                                            <li>"sometimes" or "never" quiet at night</li>
                                            <li>"usually" quiet at night</li>
                                        </ul>
                                    </div>

                                    <div class="pie-chart">
                                        <h5>Patients reported they would recommend the hospital?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_RECMND_DY','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_RECMND_PY','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_RECMND_DN','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>"Yes", patients would definitely recommend the hospital</li>
                                            <li>"No", patients would not recommend the hospital(they probably would not or definitely would not recommend it)</li>
                                            <li>"YES", patients would probably recommend the hospital</li>
                                        </ul>
                                    </div>

                                </div>

                                <div class="inner-box">
                                    <div class="pie-chart">
                                        <h5>Nurses explained things so they could understand?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_NURSE_EXPLAIN_A_P','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_NURSE_EXPLAIN_U_P','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_NURSE_EXPLAIN_SN_P','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Nurses "always" explained things so they could understand</li>
                                            <li>Nurses "sometimes" or "never" explained things so they could understand</li>
                                            <li>Nurses "usually" explained things so they could understand</li>
                                        </ul>
                                    </div>
                                    <div class="pie-chart">
                                        <h5>Patients who gave their hospital a rating on a scale from 0 (lowest) to 10 (highest)?</h5>
                                        <p>
                                            <canvas class="chart" data-always="{{NationalScoreDetails('NATIONAL','H_HSP_RATING_9_10','PatientSurvey')->answer_percent??"0"}}" data-sometimes="{{NationalScoreDetails('NATIONAL','H_HSP_RATING_7_8','PatientSurvey')->answer_percent??"0"}}" data-usually="{{NationalScoreDetails('NATIONAL','H_HSP_RATING_0_6','PatientSurvey')->answer_percent??"0"}}"></canvas>
                                        </p>
                                        <ul class="chartline">
                                            <li>Patients who gave a rating of "9" or "10" (High)?</li>
                                            <li>Patients who gave a rating of "6" or lower (low)</li>
                                            <li>Patients who gave a rating of "7" or "8" (medium)</li>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="inner-box">
                                    <h5>Measured Dates:</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_1_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}}</br> to </br>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_1_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_1_A_P','PatientSurvey')->start_date??"0000-00-00")->format('m-d-Y')}} </br> to </br> {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','H_COMP_1_A_P','PatientSurvey')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>

                    </ul>
                </div>
            </div>
            @include( frontend_module_view('hospitalScore.more-info-national', 'Page'))


        </div>
    </div>

@endsection


@push('modals')
    <div class="modal fade" id="share-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>Share</h2>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <ul class="p-0">
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="facebook">
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="twitter">
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks const-share-hospital" data-channel="linkedin">
                                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="javascript:void(0);" class="shareModalLinks" data-channel="copy">
                                        <i class="fas fa-copy" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush
