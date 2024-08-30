@extends( front_layout('master') )
@section('title', $page_title)
@section('content')
@section('meta_tags')
    <meta property="url" content="{{ route(front_route('page.national.readmission')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $page_title }}" />
    <meta property="og:url" content="{{ route(front_route('page.national.readmission')) }}" />
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
                    <h2>National Readmission Rates</h2>
                    <div class="img">
                        <img src="{{asset(front_asset('images/single-readmission.webp'))}}" alt="single-infection">
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
                            <h4>Hospital return days for heart attack patients</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospitals Fewer</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_AMI','PatientUnplannedVisit')->number_of_hospitals_fewer??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Average</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_AMI','PatientUnplannedVisit')->number_of_hospitals_average??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals More</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_AMI','PatientUnplannedVisit')->number_of_hospitals_more??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Small to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','EDAC_30_AMI','PatientUnplannedVisit')->number_of_hospitals_too_small??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','EDAC_30_AMI','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','EDAC_30_AMI','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Hospital return days for heart failure patients</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospitals Fewer</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_HF','PatientUnplannedVisit')->number_of_hospitals_fewer??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Average</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_HF','PatientUnplannedVisit')->number_of_hospitals_average??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals More</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_HF','PatientUnplannedVisit')->number_of_hospitals_more??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Small to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','EDAC_30_HF','PatientUnplannedVisit')->number_of_hospitals_too_small??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','EDAC_30_HF','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','EDAC_30_HF','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Hospital return days for pneumonia patients</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>Hospitals Fewer</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_PN','PatientUnplannedVisit')->number_of_hospitals_fewer??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Average</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_PN','PatientUnplannedVisit')->number_of_hospitals_average??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals More</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','EDAC_30_PN','PatientUnplannedVisit')->number_of_hospitals_more??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Small to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','EDAC_30_PN','PatientUnplannedVisit')->number_of_hospitals_too_small??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','EDAC_30_PN','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','EDAC_30_PN','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Rate of unplanned hospital visits after colonoscopy (per 1,000 colonoscopies)</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','OP_32','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','OP_32','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','OP_32','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','OP_32','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','OP_32','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_32','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_32','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Rate of inpatient admissions for patients receiving outpatient chemotherapy</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','OP_35_ADM','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','OP_35_ADM','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','OP_35_ADM','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','OP_35_ADM','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','OP_35_ADM','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_35_ADM','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_35_ADM','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Rate of emergency department (ED) visits for patients receiving outpatient chemotherapy</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','OP_35_ED','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','OP_35_ED','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','OP_35_ED','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','OP_35_ED','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','OP_35_ED','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_35_ED','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_35_ED','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Ratio of unplanned hospital visits after hospital outpatient surgery</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','OP_36','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','OP_36','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','OP_36','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','OP_36','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','OP_36','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_36','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','OP_36','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Acute Myocardial Infraction (AMI) 30-day Readmission Rate</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','READM_30_AMI','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','READM_30_AMI','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','READM_30_AMI','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','READM_30_AMI','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','READM_30_AMI','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_AMI','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_AMI','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Rate of readmission for CABG</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','READM_30_CABG','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','READM_30_CABG','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','READM_30_CABG','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','READM_30_CABG','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','READM_30_CABG','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_CABG','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_CABG','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Rate of readmission for chronic obstructive pulmonary disease (COPD) patients</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','READM_30_COPD','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','READM_30_COPD','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','READM_30_COPD','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','READM_30_COPD','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','READM_30_COPD','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_COPD','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_COPD','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Heart failure (HF) 30-Day Readmission Rate</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','READM_30_HF','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','READM_30_HF','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','READM_30_HF','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','READM_30_HF','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','READM_30_HF','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_HF','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_HF','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>


                        <li class="white">
                            <h4>Rate of readmission after hip/knee replacement</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','READM_30_HIP_KNEE','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','READM_30_HIP_KNEE','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','READM_30_HIP_KNEE','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','READM_30_HIP_KNEE','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','READM_30_HIP_KNEE','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_HIP_KNEE','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_HIP_KNEE','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>

                        <li class="white">
                            <h4>Rate of readmission after discharge from hospital (hospitalwide)</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','READM_30_HOSP_WIDE','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','READM_30_HOSP_WIDE','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','READM_30_HOSP_WIDE','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','READM_30_HOSP_WIDE','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','READM_30_HOSP_WIDE','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_HOSP_WIDE','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_HOSP_WIDE','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
                                </div>
                            </div>
                        </li>
                        <li class="white">
                            <h4>Pneumonia (PN) 30- Day Readmission Rate</h4>
                            <div class="boxes">
                                <div class="inner-box">
                                    <h5>National Rate</h5>
                                    <p><a class="btn">{{NationalScoreDetails('NATIONAL','READM_30_PN','PatientUnplannedVisit')->national_rate??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Worse</h5>
                                    <p><a class="btn redbtn">{{NationalScoreDetails('NATIONAL','READM_30_PN','PatientUnplannedVisit')->number_of_hospitals_worse??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Same</h5>
                                    <p><a class="btn yellowbtn">{{NationalScoreDetails('NATIONAL','READM_30_PN','PatientUnplannedVisit')->number_of_hospitals_same??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals Better</h5>
                                    <p><a class="btn greenbtn">{{NationalScoreDetails('NATIONAL','READM_30_PN','PatientUnplannedVisit')->number_of_hospitals_better??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Hospitals with Too Few to Measure</h5>
                                    <p><a class="btn bluebtn">{{NationalScoreDetails('NATIONAL','READM_30_PN','PatientUnplannedVisit')->number_of_hospitals_too_few??"0"}}</a></p>
                                </div>
                                <div class="inner-box">
                                    <h5>Measured dates</h5>
                                    <p>{{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_PN','PatientUnplannedVisit')->start_date??"0000-00-00")->format('m-d-Y')}} to {{carbon\carbon::parse(NationalScoreDetails('NATIONAL','READM_30_PN','PatientUnplannedVisit')->end_date??"0000-00-00")->format('m-d-Y')}}</p>
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
