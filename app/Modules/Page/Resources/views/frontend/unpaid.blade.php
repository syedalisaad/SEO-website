@extends( front_layout('master') )
@section('title', $page_title)
@section('meta_tags')
    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('page.unpaid'), $hospital->slug) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $page_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta property="description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.unpaid'), $hospital->slug) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $page_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}"/>
    @else
        <meta property="og:description" content="{{ $hospital->short_desc ?: $hospital->hospital_ownership ?: '' }}"/>
    @endif

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
@section('content')

    <div class="unsubscribe">
        <div class="custom-container">
            <div class="row">
                <div class="col-md-2">
                    <a class="bacnbtn back_near_me" href="{{route(front_route('page.hospital.list'))}}" ><i class="fas fa-angle-double-left"></i> Back</a>
                </div>
                <div class="col-md-10">
                    @include( frontend_module_view('hospitalScore.stars', 'Page') , ['item' => $hospital])
                </div>
            </div>

            <div class="row sub-detial">
                <div class="col-md-6">
                    <h2 class="catheading">
                        @include(frontend_module_view('premium-info._name', 'Page'), ['hospital' => $hospital])
                        @if( $hospital->industry_leader == 1 )
                            <div class="industry_leader">
                                <img src="{{ asset(front_asset('images/industryleader.png')) }}" /> Industry Leader
                            </div>
                        @endif
                    </h2>
                    <a href="{{ route(front_route('user.dashboard')) }}" class="feabtn">Feature Your Hospital</a>
                </div>
                <div class="col-md-6">
                    <div class="img unsub">
{{--                        <img src="{{asset(front_asset('images/unsubscribe-hospital.webp'))}}" alt="">--}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="line"></div>
                </div>
            </div>

            <div class="row info">
                <div class="col-md-3">
                    <h4>Hospital Info</h4>
                    <ul>
                        <li>
                            <h5>Location:</h5>
                            <a>{{$hospital->formatted_address}}</a>
                        </li>
                        <li>
                            <h5>Phone:</h5>
                            <a href="tel:{{$hospital->phone_number}}">{{$hospital->phone_number}}</a>
                        </li>
                    </ul>
                    <a class="hosp-url" href="{{ route(front_route('user.dashboard')) }}">Add Hospital URL</a>
                </div>
                <div class="col-md-6 box">
                    <ul>
                        <li>
                            <h5>Serving Patients in:</h5>
                            <p>{{$hospital->county_name}}</p>
                        </li>
                        <li>
                            <h5>Healthcare workers given influenza vaccination:</h5>
                            <p>{{$healthcare_vaccination->score??'-'}}</p>
                        </li>
                        <li>
                            <h5>Type of Hospital:</h5>
                            <p>{{$hospital->hospital_type}}</p>
                        </li>
                        <li>
                            <h5>Emergency department volume:</h5>
                            <p>{{$healthcare_volume->score??'-'}}</p>
                        </li>
                        <li>
                            <h5>Emergency Services:</h5>
                            <p>{{$hospital->emergency_services}}</p>
                        </li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <div class="share">
                        <a href="javascript:void(0)"><i class="fas fa-share-square"></i> Share this Hospital</a>
                    </div>
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
