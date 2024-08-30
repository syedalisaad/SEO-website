@php
    $site_settings  = get_site_settings();
    $meta_title     = $seo_metadata['meta_title'] ?? 'Premium';
@endphp
@extends( front_layout('master') )
@section('title', 'Premium')
@section('meta_tags')


    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('page.premium'), $hospital->slug) }}"/>
    <meta property="type" content="article"/>
    <meta property="title" content="{{ $meta_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta property="description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.premium'), $hospital->slug) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $meta_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta name="og:description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta name="og:description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif
    @if(isset($hospital->hospital_info->share_image) && !empty($hospital->hospital_info->share_image) && $hospital->hospital_info->share_image!=null)
        <meta property="image" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image:url" content="{{$hospital->hospital_info->image_url_share}}"/>
        <meta property="og:image:width" content="400"/>
        <meta property="og:image:height" content="300"/>
        <meta name=”twitter:title” content="{{ $meta_title }}"/>
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
            <meta name=”twitter:title” content="{{ $meta_title }}"/>
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
@push('style')
    <style>
        button.ytp-large-play-button.ytp-button {
            display: none;
        }
    </style>

@endpush
@section('content')
    <style>
        iframe.video {
            width: 100%;
            height: 500px;
        }

        .ytp-large-play-button svg {
            border-radius: 50% !important;
            height: 50px !important;
            background-color: white !important;
        }
    </style>

    <div class="unsubscribe" id="subscribe">
        <div class="custom-container">

            <div class="row align-items-center">
                <div class="col-md-2">
                    <a class="bacnbtn"><i class="fas fa-angle-double-left"></i> Back</a>
                </div>
                <div class="col-md-10">
                    @include( frontend_module_view('hospitalScore.stars', 'Page') , ['item' => $hospital])

                </div>
            </div>

            <!--- INFORMATION - HOSPITAL  -->
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

                </div>
                <div class="col-md-7">
                    @include(frontend_module_view('premium-info._slider', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])
                </div>
            </div>


            @include(frontend_module_view('premium-info._info', 'Page'), ['hospital' => $hospital,'subscribe_order' => $subscribe_order])

        <!--- INFORMATION - HOSPITAL  -->
            <div class="d-none">
                <div class="row d-flex justify-content-end mt-5">
                    <div class="col-md-7">
                        <div class="benchmark">
                            <h6>Compared to National Benchmark:</h6>
                            <ul class="rates">
                                <li><a class="btn red" href="#">Worse</a></li>
                                <li><a class="btn yellow" href="#">Good</a></li>
                                <li><a class="btn green" href="#">Best</a></li>
                                <li><a class="btn silver" href="#">Not Available</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row listings d-none ">
                <div class="col-md-9">
                    <h2>Infections</h2>
                    <div class="img">
                        <img src="{{asset(front_asset('images/single-infection.webp'))}}" alt="single-infection">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="share">
                        <a href="javascript:void(0)"><i class="fas fa-share-square"></i> Share this Hospital</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <ul>
                        @if( $hospital->infection_patients->count() )
                            @foreach($hospital->infection_patients as $patient_infection)
                                <li class="white">
                                    <h4>{{$patient_infection->measure_name}}</h4>
                                    <div class="boxes">
                                        <div class="inner-box">
                                            <h5>Score:</h5>
                                            <p class="btn {{ $patient_infection->score_class }}">{{$patient_infection->score}}</p>
                                        </div>
                                        <div class="inner-box">
                                            <h5>Footnote:</h5>
                                            <p>{!! $patient_infection->footnote?:'-' !!}</p>
                                        </div>
                                        <div class="inner-box">
                                            <h5>Start Date:</h5>
                                            <p>{{$patient_infection->start_date?:'-'}}</p>
                                        </div>
                                        <div class="inner-box">
                                            <h5>End Date:</h5>
                                            <p>{{$patient_infection->end_date?:'-'}}</p>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        @else
                            <li class="white">Not available</li>
                        @endif
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

