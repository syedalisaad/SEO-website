@extends( front_layout('master') )
@section('title', $page_title)
@section('content')
@section('meta_tags')
    <meta property="url" content="{{ route(front_route('page.national.speed-of-care')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $page_title }}" />
    <meta property="og:url" content="{{ route(front_route('page.national.speed-of-care')) }}" />
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
                    <h2>National Speed of Care Scores</h2>
                    <div class="img">
                        <img src="{{asset(front_asset('images/single-care.webp'))}}" alt="single-infection">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="share">
                        <a href="javascript:void(0)"><i class="fas fa-share-square"></i> Share this Hospital</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul class="national_date">
                        <li class="white">
                            <h4>Time patients spent in the emergency department before leaving from the visit. A lower number of minutes is better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_18b_NINETIETH')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Low</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_18b_LOW_MIN')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Moderate</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_18b_MEDIUM_MIN')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_18b')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>High</h5>
                                    <p><a class="btn redbtn">{{patientSpeedOfCare('NATIONAL','OP_18b_HIGH_MIN')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Very Hight</h5>
                                    <p><a class="btn redbtn">{{patientSpeedOfCare('NATIONAL','OP_18b_VERY_HIGH_MIN')->score??"0"}}</a></p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Time patients spent in the emergency department before leaving from the visit- Psychiatric/ Mental Health Patients. A lower number of minutes is better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_18c_NINETIETH')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Low</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_18c_LOW_MIN')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Moderate</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_18c_MEDIUM_MIN')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_18c')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>High</h5>
                                    <p><a class="btn redbtn">{{patientSpeedOfCare('NATIONAL','OP_18c_HIGH_MIN')->score??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Very Hight</h5>
                                    <p><a class="btn redbtn">{{patientSpeedOfCare('NATIONAL','OP_18c_VERY_HIGH_MIN')->score??"0"}}</a></p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Outpatients with chest pain or possible heart attack who got drugs to break up blood clots within 30 minutes of arrival. High percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_2')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_2_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_2')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_2')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Percentage of patients who left the emergency department before being seen. Lower percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_22')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_22_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_22')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_22')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Percentage of patients who came to the emergency department with stroke symptoms who received brain scan results within 45 minutes of arrival. Higher percentages are better</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_23')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_23_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_23')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_23')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Percentage of patients receiving appropriate recommendation for follow-up screening colonoscopy. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_29')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_29_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_29')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_29')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Percentage of patients who had cataract surgery and had improvement in visual function within 90 days following the surgery. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_31')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_31_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_31')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_31')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Percentage of patients receiving appropriate radiation therapy for cancer that has spread to the bone. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_33')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_33_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_33')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_33')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Average number of minutes before outpatients with chest pain or possible heart attack who needed specialized care were transferred to another hospital. A lower number of minutes is better</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','OP_3b')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_3b_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_3b_NINETIETH')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','OP_3b')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Percent of mothers whose deliveries were scheduled too early (1-2 weeks early), when a scheduled delivery was not medically necessary. Lower percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','PC_01')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','PC_01_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','PC_01')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','PC_01')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Percentage of patients who received appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','SEP_1')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','SEP_1_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEP_1')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEP_1')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Septic Shock 3-Hour Bundle. Appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','SEP_SH_3HR')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','SEP_SH_3HR_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEP_SH_3HR')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEP_SH_3HR')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Septic Shock 6-Hour Bundle. Appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','SEP_SH_6HR')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','SEP_SH_6HR_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEP_SH_6HR')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEP_SH_6HR')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Severe Septic Shock 3-Hour Bundle. Appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','SEV_SEP_3HR')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','SEV_SEP_3HR_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEV_SEP_3HR')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEV_SEP_3HR')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Severe Septic Shock 6-Hour Bundle. Appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Median</h5>
                                    <p><a class="btn yellowbtn">{{patientSpeedOfCare('NATIONAL','SEV_SEP_6HR')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','SEV_SEP_6HR_NINETIETH')->score??"0"}}%</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEV_SEP_6HR')->start_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{carbon\carbon::parse(patientSpeedOfCare('NATIONAL','SEV_SEP_6HR')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
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
