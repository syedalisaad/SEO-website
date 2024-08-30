@php
    $site_settings  = get_site_settings();
    $seo_metadata   = $site_settings['seo_metadata'] ?? [];
    $page_title     = $seo_metadata['meta_title'] ?? 'Home';
@endphp
@extends( front_layout('master') )
@section('title', 'Home')
@section('meta_tags')

    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif
    <meta property="url" content="{{ url('/') }}"/>
    <meta property="type" content="article"/>
    <meta property="title" content="{{ $page_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif
    <meta property="og:url" content="{{ url('/') }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $page_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    @if( isset($site_settings['sites']) && isset($site_settings['sites']['share_logo']) )
        <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}"/>
    @endif
@endsection
@section('content')
    <section class="want">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if( isset($site_settings['frontend_support']['frontend_video_box_1']) && !empty($site_settings['frontend_support']['frontend_video_box_1']['title']) )
                        <h2>
                            {{$site_settings['frontend_support']['frontend_video_box_1']['title']}}
                        </h2>
                    @else
                        <h2>We All Want To Know More About Hospitals</h2>
                    @endif
                    @if( isset($site_settings['frontend_support']['frontend_video_box_1']) && !empty($site_settings['frontend_support']['frontend_video_box_1']['description']) )
                        <p>
                            {{$site_settings['frontend_support']['frontend_video_box_1']['description']}}
                        </p>
                    @else
                        <p>See how we are bringing more transparency in the video below</p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <div class="img">
{{--                        <img src="{{ asset(front_asset('images/googleads.webp')) }}" alt="google-adds">--}}
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="img">
                        @if( isset($site_settings['frontend_support']['frontend_video_box_1']) && isset($site_settings['frontend_support']['frontend_video_box_1']['video_upload_status']) && $site_settings['frontend_support']['frontend_video_box_1']['video_upload_status']==1  &&  !empty($site_settings['frontend_support']['frontend_video_box_1']['youtube']) )
                            <a data-fancybox="gallery" class="img" href="{{ $site_settings['frontend_support']['frontend_video_box_1']['youtube']}}">
                                <img src="{{ asset(front_asset('images/want-video.webp')) }}" alt="video-overlay">
                            </a>
                        @elseif( isset($site_settings['frontend_support']['frontend_video_box_1']) && isset($site_settings['frontend_support']['frontend_video_box_1']['video_upload_status']) && $site_settings['frontend_support']['frontend_video_box_1']['video_upload_status']==0  &&  !empty($site_settings['frontend_support']['frontend_video_box_1']['video_upload']) )
                            <a data-fancybox="gallery" class="img" href="{{ \App\Models\Setting::getImageURL($site_settings['frontend_support']['frontend_video_box_1']['video_upload'])}}">
                                <img src="{{ asset(front_asset('images/want-video.webp')) }}" alt="video-overlay">
                            </a>
                        @else
                            <img src="{{ asset(front_asset('images/want-video.webp')) }}" alt="video-overlay">
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="img">
{{--                        <img src="{{ asset(front_asset('images/googleads.webp')) }}" alt="google-adds">--}}
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="moreinfo national speciality">
        <div class="custom-container">
            <div class="row">
                <div class="col-md-12">
                    <h3><b>National Averages and Measures</b></h3>
                </div>

                <div class="col-md-3">
                    <div class="sbox">
                        <div class="img">
                            <a href="{{route(front_route('page.national.infection'))}}">
                                <img src="{{asset(front_asset('images/infection.webp'))}}" alt="infection">
                            </a>
                        </div>
                        <h4>Infection</h4>
                        <p>A list of different infections along with infection related conditions being measured at each reporting hospital.</p>
                        <a href="{{route(front_route('page.national.infection'))}}">View
                            More <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="sbox">
                        <div class="img">
                            <a href="{{route(front_route('page.national.survey'))}}">
                                <img src="{{asset(front_asset('images/patient.webp'))}}" alt="patient">
                            </a>
                        </div>
                        <h4>Patient Experience</h4>
                        <p>The combined scores of all the measured hospitals to show the national scores for patient surveys.</p>
                        <a href="{{route(front_route('page.national.survey'))}}">View More
                            <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="sbox">
                        <div class="img">
                            <a href="{{route(front_route('page.national.death_and_complication'))}}">
                                <img src="{{asset(front_asset('images/complication.webp'))}}" alt="complication">
                            </a>
                        </div>
                        <h4>Death & Complication</h4>
                        <p>A breakdown for each category of the number of hospitals who scored below average, at average, or above average in the nation.</p>
                        <a href="{{route(front_route('page.national.death_and_complication'))}}">View
                            More <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="sbox">
                        <div class="img">
                            <a href="{{route(front_route('page.national.readmission'))}}">
                                <img src="{{asset(front_asset('images/readmission.webp'))}}" alt="readmission">
                            </a>
                        </div>
                        <h4>Readmission</h4>
                        <p>A high level view of the number of hospitals who have patients returning for additional care.</p>
                        <a href="{{route(front_route('page.national.readmission'))}}">View
                            More <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="sbox">
                        <div class="img">
                            <a href="{{route(front_route('page.national.speed-of-care'))}}">
                                <img src="{{asset(front_asset('images/care.webp'))}}" alt="care">
                            </a>
                        </div>
                        <h4>Speed of Care</h4>
                        <p>A list of the situations being measured, and the associated speed of those measures.</p>
                        <a href="{{route(front_route('page.national.speed-of-care'))}}">View
                            More <i class="fas fa-long-arrow-alt-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

 {{--   <section class="speciality">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>National Averages and Measures</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="sp-slider">
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/infection.webp'))}}" alt="infection">
                            </div>
                            <h4>Infection</h4>
                            <p>A list of different infections along with infection related conditions being measured at each reporting hospital.</p>
                            <a href="{{route(front_route('page.national.infection'))}}">Read More Details <img src="{{asset(front_asset('images/right-arrow-blue.webp'))}}" alt="right-arrow-blue"></a>
                        </div>
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/patient.webp'))}}" alt="patient">
                            </div>
                            <h4>Patient Experience</h4>
                            <p>The combined scores of all the measured hospitals to show the national scores for patient surveys.</p>
                            <a href="{{route(front_route('page.national.survey'))}}">Read More Details <img src="{{asset(front_asset('images/right-arrow-blue.webp'))}}" alt="right-arrow-blue"></a>
                        </div>
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/complication.webp'))}}" alt="complication">
                            </div>
                            <h4>Death & Complication</h4>
                            <p>A breakdown for each category of the number of hospitals who scored below average, at average, or above average in the nation.</p>
                            <a href="{{route(front_route('page.national.death_and_complication'))}}">Read More Details <img src="{{asset(front_asset('images/right-arrow-blue.webp'))}}" alt="right-arrow-blue"></a>
                        </div>
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/readmission.webp'))}}" alt="child">
                            </div>
                            <h4>Readmission</h4>
                            <p>A high level view of the number of hospitals who have patients returning for additional care</p>
                            <a href="{{route(front_route('page.national.readmission'))}}">Read More Details <img src="{{asset(front_asset('images/right-arrow-blue.webp'))}}" alt="right-arrow"></a>
                        </div>
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/care.webp'))}}" alt="readmission">
                            </div>
                            <h4>Speed of Care</h4>
                            <p>A list of the situations being measured, and the associated speed of those measures.</p>
                            <a href="{{route(front_route('page.national.speed-of-care'))}}">Read More Details <img src="{{asset(front_asset('images/right-arrow-blue.webp'))}}" alt="right-arrow"></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>--}}
    <section class="find d-none">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Let's Find The Right Hospital For You!</h2>
                    <p>Start your Search Now!</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <form name="findform" method="POST" class="findform const-hospital-form" action="" data-action="{{ route(front_route('page.hospital.list')) }}">
                        <div class="search">
                            <select class="select2" style="width: 100%;">
                            </select>
                            <input class="select2-selection__rendered_show" value="{{request()->get('hospital')??''}}" name="name" hidden style="width: 100%;">
                        </div>
                        <div class="spann-or">OR</div>
                        <div class="zipcode">
                            <input type="text" class="pac-input" maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" name="zipcode" git pull placeholder="Start with 3 digits of Zipcode"/>
                            <input type="hidden" name="zipcode_hidden" value="">
                        </div>
                        <div class="name_zip_required"></div>
                        <input type="button" onclick="searchValidate()" name="submit" class="const-search-hospitals" value="Search">
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="img">
                        <img src="{{ asset( front_asset('images/find-form.webp'))}}" alt="checkup">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="videobg pt-2">
        <div class="videocontent">
            <div class="custom-container">
                <div class="row">
                    <div class="col-md-12">
                        @if( isset($site_settings['frontend_support']['frontend_video_box_2']) && !empty($site_settings['frontend_support']['frontend_video_box_2']['description']) )
                            <h2>{{$site_settings['frontend_support']['frontend_video_box_2']['description']}}</h2>
                        @else
                            <h2>Just Getting Started With GoodHospitalBadHospital.Com? <br>Our Walkthrough Video Will Help You Find What Is Available In Your Area.</h2>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="img">
            @if( isset($site_settings['frontend_support']['frontend_video_box_2']) && isset($site_settings['frontend_support']['frontend_video_box_2']['video_upload_status']) && $site_settings['frontend_support']['frontend_video_box_2']['video_upload_status']==1  &&  !empty($site_settings['frontend_support']['frontend_video_box_2']['youtube']) )
                <a data-fancybox="gallery" href="{{  $site_settings['frontend_support']['frontend_video_box_2']['youtube']}}">
                    <div class="img">
                        <img src="{{ asset( front_asset('images/mainvideo.webp'))}}" alt="background-video">
                    </div>
                </a>
            @elseif( isset($site_settings['frontend_support']['frontend_video_box_2']) && isset($site_settings['frontend_support']['frontend_video_box_2']['video_upload_status']) && $site_settings['frontend_support']['frontend_video_box_2']['video_upload_status']==0  &&  !empty($site_settings['frontend_support']['frontend_video_box_2']['video_upload']) )

                <a data-fancybox="gallery" href="{{ \App\Models\Setting::getImageURL($site_settings['frontend_support']['frontend_video_box_2']['video_upload'])}}">
                    <div class="img">
                        <img src="{{ asset( front_asset('images/mainvideo.webp'))}}" alt="background-video">
                    </div>
                </a>
            @else
                <img src="{{ asset( front_asset('images/mainvideo.webp'))}}" alt="background-video">
            @endif

        </div>
    </section>
    <section class="news">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route(front_route('blog.index')) }}">
                    <h2><b>FAQ’s and Latest Updates</b></h2>
                    </a>
                    <span>Here are some of our most Frequently Asked Questions. For even more information, see our <a href="{{route(front_route('page.faq'))}}">FAQ’s page</a>. </span>
                </div>
            </div>
            @if( isset($posts) && $posts->count() )

                <div class="row">
                    @foreach($posts as $post)
                        <div class="col-md-4">
                            <div class="img">
                                <a href="{{route(front_route('blog.single'),$post->slug)}}">
                                <img src="{{ $post->image_url }}" alt="{{ $post->name }}">
                                </a>
                            </div>

                            <h3>{{ $post->name }}</h3>
                            <p>{{ $post->short_desc }}</p>
                            <a href="{{route(front_route('blog.single'),$post->slug)}}">Read More <i class="fa fa-long-arrow-right"></i></a>
                        </div>
                    @endforeach
                </div>
        </div>
        @endif
    </section>

@endsection
@push('scripts')
    <script>
        function searchValidate() {
            if (document.forms['findform'].zipcode.value == "" && document.forms['findform'].name.value == "") {
                $('.name_zip_required').html("You need to complete at least 1 field to conduct a search")
            }
        }
    </script>
@endpush()
