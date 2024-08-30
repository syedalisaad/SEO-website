@extends( front_layout('master') )
@section('title', $page_title)
@section('content')
@section('meta_tags')
    <meta property="url" content="{{ route(front_route('page.national.death_and_complication')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $page_title }}" />
    <meta property="og:url" content="{{ route(front_route('page.national.death_and_complication')) }}" />
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
                    <h2>National Death and Complication</h2>
                    <div class="img">
                        <img src="{{asset(front_asset('images/single-death.webp'))}}" alt="single-infection">
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
                            <h4>Rate of complications for hip/knee replacement patients</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','COMP_HIP_KNEE','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','COMP_HIP_KNEE','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','COMP_HIP_KNEE','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','COMP_HIP_KNEE','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','COMP_HIP_KNEE','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','COMP_HIP_KNEE','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','COMP_HIP_KNEE','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Death rate for heart attack patients <a href="{{ route(front_route('page.faq')).'?faq=10' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a> </h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_AMI','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','MORT_30_AMI','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','MORT_30_AMI','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','MORT_30_AMI','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_AMI','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_AMI','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_AMI','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Death rate for CABG surgery patients <a href="{{ route(front_route('page.faq')).'?faq=11' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_CABG','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','MORT_30_CABG','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','MORT_30_CABG','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','MORT_30_CABG','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_CABG','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_CABG','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_CABG','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Death rate for COPD patients <a href="{{ route(front_route('page.faq')).'?faq=12' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_COPD','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','MORT_30_COPD','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','MORT_30_COPD','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','MORT_30_COPD','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_COPD','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_COPD','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_COPD','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Death rate for heart failure patients <a href="{{ route(front_route('page.faq')).'?faq=10' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_HF','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','MORT_30_HF','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','MORT_30_HF','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','MORT_30_HF','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_HF','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_HF','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_HF','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Death rate for pneumonia patients</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_PN','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','MORT_30_PN','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','MORT_30_PN','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','MORT_30_PN','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_PN','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_PN','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_PN','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Death rate for stroke patients</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_STK','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','MORT_30_STK','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','MORT_30_STK','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','MORT_30_STK','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','MORT_30_STK','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_STK','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','MORT_30_STK','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Pressure ulcer rate</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_03','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_03','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_03','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_03','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_03','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_03','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_03','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Death rate among surgical inpatients with serious treatable complication</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_04','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_04','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_04','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_04','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_04','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_04','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_04','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Iatrogenic pneumothorax rate <a href="{{ route(front_route('page.faq')).'?faq=13' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_06','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_06','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_06','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_06','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_06','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_06','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_06','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>In-hospital fall with hip fracture rate</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_08','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_08','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_08','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_08','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_08','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_08','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_08','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Perioperative hemorrhage or hematoma rate <a href="{{ route(front_route('page.faq')).'?faq=14' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_09','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_09','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_09','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_09','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_09','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_09','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_09','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Postoperative acute kidney injury requiring dialysis rate</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_10','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_10','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_10','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_10','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_10','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_10','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_10','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Postoperative respiratory failure rate</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_11','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_11','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_11','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_11','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_11','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_11','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_11','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Perioperative pulmonary embolism or deep vein thrombosis rate <a href="{{ route(front_route('page.faq')).'?faq=17' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_12','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_12','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_12','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_12','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_12','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_12','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_12','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Postoperative sepsis rate <a href="{{ route(front_route('page.faq')).'?faq=19' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_13','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_13','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_13','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_13','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_13','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_13','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_13','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Postoperative wound dehiscence rate <a href="{{ route(front_route('page.faq')).'?faq=20' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_14','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_14','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_14','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_14','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_14','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_14','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_14','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Abdominopelvic accidental puncture or laceration rate <a href="{{ route(front_route('page.faq')).'?faq=21' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_15','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_15','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_15','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_15','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_15','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_15','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_15','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>CMS Medicare PSI 90: Patient safety and adverse events composite <a href="{{ route(front_route('page.faq')).'?faq=23' }}" target="_blank" style="float: right" >Learn More <i class="fas fa-external-link-alt"></i></a></h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_90','PatientComplicationAndDeath')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','PSI_90','PatientComplicationAndDeath')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','PSI_90','PatientComplicationAndDeath')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','PSI_90','PatientComplicationAndDeath')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','PSI_90','PatientComplicationAndDeath')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                     <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_90','PatientComplicationAndDeath')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','PSI_90','PatientComplicationAndDeath')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
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
