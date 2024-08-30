@extends( front_layout('master') )
@section('title', $page_title)
@section('meta_tags')
    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('page.hospital.speed-of-care'), $hospital->slug) }}"/>
    <meta property="type" content="article"/>
    <meta property="title" content="{{ $page_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta property="description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.unpaid'), $hospital->slug) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $page_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta property="og:description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif
    @if(isset($hospital->hospital_info->share_image) && !empty($hospital->hospital_info->share_image) && $hospital->hospital_info->share_image!=null)
        <meta property="image" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image:url" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image:width" content="400"/>
        <meta property="og:image:height" content="300"/>
        <meta name=”twitter:title” content="{{ $page_title }}"/>
        <meta name="twitter:image:src" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta name="twitter:image" content="{{$hospital->hospital_info->image_url_share}}"/>

    @else
        @php $site_settings = get_site_settings(); @endphp
        @if( isset($hospital->hospital_info->image_url_logo) )
            <meta property="image" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta property="og:image" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta property="og:image:url" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta property="og:image:width" content="400"/>
            <meta property="og:image:height" content="300"/>
            <meta name=”twitter:title” content="{{ $page_title }}"/>
            <meta name="twitter:image:src" content="{{$hospital->hospital_info->image_url_logo}}"/>
            <meta name="twitter:image" content="{{$hospital->hospital_info->image_url_logo}}"/>
        @else
            <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image:url" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta property="og:image:width" content="400"/>
            <meta property="og:image:height" content="300"/>
            <meta name="twitter:image:src" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
            <meta name="twitter:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        @endif
    @endif

@endsection
@section('content')

	<?php
	use \App\Models\PatientTimelyAndEffectiveCare;

	$hospital_speed_of_care = $hospital->speed_of_care_hospitals;
	$national_speed_of_care = $hospital->speed_of_care_nationals;
	?>

    <div class="unsubscribe infection">

        <div class="custom-container">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <a class="bacnbtn" href="{{route(front_route('page.unpaid'),$hospital->slug)}}"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>
                <div class="col-md-10">
                    @include( frontend_module_view('hospitalScore.stars', 'Page') , ['item' => $hospital])
                </div>
            </div>

            <div class="row sub-detial d-flex align-items-center">
                <div class="col-md-5">
                    <div class="shelby d-flex flex-column align-items-start">
                        @include(frontend_module_view('premium-info._logo', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                        <div class="share">
                            <a href="javascript:void(0)"><i class="fas fa-share-square"></i> Share this Hospital</a>
                        </div>
                    </div>
                    <h2 class="catheading">
                        @include(frontend_module_view('premium-info._name', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                    </h2>

                    <div class="info">
                        @include(frontend_module_view('premium-info._left_info', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                    </div>
                </div>
                <div class="col-md-7">
                    @include(frontend_module_view('premium-info._slider', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                    <div class="row d-flex justify-content-end mt-5">
                        <div class="benchmark">
                            <h6>Compared to National Benchmark:</h6>
                            <ul class="rates">
                                <li><a class="btn blue">This Hospital's Scores</a></li>
                                <li><a class="btn yellow">Average Hospital Score</a></li>
                                <li><a class="btn green">Top 10% Score</a></li>
                                <li><a class="btn silver">Not Available</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row listings">
                <div class="col-md-9">
                    <h2>Speed of Care</h2>
                    <div class="img">
                        <img src="{{asset(front_asset('images/single-care.webp'))}}" alt="single-care">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="share">
                        <a href="#"><i class="fas fa-share-square"></i> Share this Hospital's score</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul>
                        @php
                            $op_18b_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_18b'])->first() : null;
                            $op_18b_national = $national_speed_of_care->count() ? $national_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['NATIONAL']['OP_18b_MEDIUM_MIN'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Time patients spent in the emergency department before leaving from the visit. A lower number of minutes is better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_18b_hospital->score_average_class ?? '' }}">{{ isset($op_18b_hospital->score_average) ? str_replace('%','',$op_18b_hospital->score_average) : '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Moderate:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_18b_MEDIUM_MIN')->score)? patientSpeedOfCare('NATIONAL','OP_18b_MEDIUM_MIN')->score.'' : "0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_18b_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','OP_18b_NINETIETH')->score.'' :"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_18b_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_18b_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_18b_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_18c_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_18C'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Time patients spent in the emergency department before leaving from the visit- Psychiatric/ Mental Health Patients. A lower number of minutes is better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_18c_hospital->score_average_class ?? '' }}">{{ isset($op_18c_hospital->score_average) ? str_replace('%','',$op_18c_hospital->score_average) : '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Moderate:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_18c_MEDIUM_MIN')->score)? patientSpeedOfCare('NATIONAL','OP_18c_MEDIUM_MIN')->score.'' : "0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_18c_NINETIETH')->score) ? patientSpeedOfCare('NATIONAL','OP_18c_NINETIETH')->score.'':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_18c_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_18c_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_18c_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_2_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_2'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Outpatients with chest pain or possible heart attack who got drugs to break up blood clots within 30 minutes of arrival. High percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_2_hospital->score_average_class ?? '' }}">{{ $op_2_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_2')->score)?patientSpeedOfCare('NATIONAL','OP_2')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_2_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','OP_2_NINETIETH')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_2_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_2_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_2_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_22_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_22'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Percentage of patients who left the emergency department before being seen. Lower percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_22_hospital->score_average_class ?? '' }}">{{ $op_22_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_22',)->score)?patientSpeedOfCare('NATIONAL','OP_22',)->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_22_NINETIETH',)->score)?patientSpeedOfCare('NATIONAL','OP_22_NINETIETH',)->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_22_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_22_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_22_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_23_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_23'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Percentage of patients who came to the emergency department with stroke symptoms who received brain scan within 45 min of arrival. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_23_hospital->score_average_class ?? '' }}">{{ $op_23_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_23')->score)?patientSpeedOfCare('NATIONAL','OP_23')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{patientSpeedOfCare('NATIONAL','OP_23_NINETIETH')->score?patientSpeedOfCare('NATIONAL','OP_23_NINETIETH')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_23_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_23_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_23_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_29_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_29'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Percentage of patients receiving appropriate recommendation for follow-up screening colonoscopy. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_29_hospital->score_average_class ?? '' }}">{{ $op_29_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_29')->score)?patientSpeedOfCare('NATIONAL','OP_29')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_23_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','OP_23_NINETIETH')->score.'%' :"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_29_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_29_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_29_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_31_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_31'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Percentage of patients who had cataract surgery and had improvement in visual function within 90 days following the surgery. Higher percentages are better</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_31_hospital->score_average_class ?? '' }}">{{ $op_31_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_31')->score)?patientSpeedOfCare('NATIONAL','OP_31')->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_31_NINETIETH')->score)? patientSpeedOfCare('NATIONAL','OP_31_NINETIETH')->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_31_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_31_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_31_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_33_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_33'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Percentage of patients receiving appropriate radiation therapy for cancer that has spread to the bone. Higher percentages are better</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_33_hospital->score_average_class ?? '' }}">{{ $op_33_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_33')->score)?patientSpeedOfCare('NATIONAL','OP_33')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_33_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','OP_33_NINETIETH')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_33_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_33_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_33_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $op_3b_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['OP_3B'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Average number of minutes before outpatients with chest pain or possible heart attack who needed specialized care were transferred to another hospital. A lower number of minutes is better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $op_3b_hospital->score_average_class ?? '' }}">{{ isset($op_3b_hospital->score_average) ? str_replace('%','',$op_3b_hospital->score_average) : '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_3b')->score)?patientSpeedOfCare('NATIONAL','OP_3b')->score.'':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','OP_3b_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','OP_3b_NINETIETH')->score.'':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $op_3b_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $op_3b_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $op_3b_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $pc_01_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['PC_01'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Percent of mothers whose deliveries were scheduled too early (1-2 weeks early), when a scheduled delivery was not medically necessary. Lower percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $pc_01_hospital->score_average_class ?? '' }}">{{ $pc_01_hospital->score_average ?? '0%' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','PC_01')->score)?patientSpeedOfCare('NATIONAL','PC_01')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','PC_01_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','PC_01_NINETIETH')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $pc_01_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $pc_01_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $pc_01_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $sep_1_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['SEP_1'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Percentage of patients who received appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $sep_1_hospital->score_average_class ?? '' }}">{{ $sep_1_hospital->score_average ?? '0%' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEP_1')->score)?patientSpeedOfCare('NATIONAL','SEP_1')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEP_1_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','SEP_1_NINETIETH')->score.'%':"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $sep_1_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $sep_1_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $sep_1_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $sep_sh_3hr_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['SEP_SH_3HR'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Septic Shock 3-Hour Bundle. Appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $sep_sh_3hr_hospital->score_average_class ?? '' }}">{{ $sep_sh_3hr_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEP_SH_3HR')->score)?patientSpeedOfCare('NATIONAL','SEP_SH_3HR')->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEP_SH_3HR_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','SEP_SH_3HR_NINETIETH')->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $sep_sh_3hr_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $sep_sh_3hr_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $sep_sh_3hr_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $sep_sh_6hr_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['SEP_SH_6HR'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Septic Shock 6-Hour Bundle. Appropriate care for severe sepsis and septic shock. Higher percentages are better.</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $sep_sh_6hr_hospital->score_average_class ?? '' }}">{{ $sep_sh_6hr_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEP_SH_6HR')->score)?patientSpeedOfCare('NATIONAL','SEP_SH_6HR')->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEP_SH_6HR_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','SEP_SH_6HR_NINETIETH')->score.'%':"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $sep_sh_6hr_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $sep_sh_6hr_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $sep_sh_6hr_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>

                        @php
                            $sev_sep_3hr_hospital = $hospital_speed_of_care->count() ? $hospital_speed_of_care->where('measure_id', PatientTimelyAndEffectiveCare::$MEASURE_ID['HOSPITAL']['SEV_SEP_3HR'])->first() : null;
                        @endphp
                        <li class="white">
                            <h4>Severe Septic Shock 3-Hour Bundle. Appropriate care for severe sepsis and septic shock. Higher percentages are better</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospital:</h5>
                                    <p><a class="btn {{ $sev_sep_3hr_hospital->score_average_class ?? '' }}">{{ $sev_sep_3hr_hospital->score_average ?? '0' }}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Medium:</h5>
                                    <p><a class="btn yellowbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEV_SEP_3HR')->score)?patientSpeedOfCare('NATIONAL','SEV_SEP_3HR')->score."%":"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Top 10%:</h5>
                                    <p><a class="btn greenbtn">{{is_numeric(patientSpeedOfCare('NATIONAL','SEV_SEP_3HR_NINETIETH')->score)?patientSpeedOfCare('NATIONAL','SEV_SEP_3HR_NINETIETH')->score."%":"0%"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Footnote:</h5>
                                    <p>{!! $sev_sep_3hr_hospital->footnote_score_not_available ?? "-" !!}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>Start Date:</h5>
                                    <p>{{ $sev_sep_3hr_hospital->start_date ?? "-"}}</p>
                                </div>
                                <div class="inner-box">
                                    <h5>End Date:</h5>
                                    <p>{{ $sev_sep_3hr_hospital->end_date ?? "-"}}</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            @include( frontend_module_view('hospitalScore.more-info-hospital', 'Page'))
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
