@extends( front_layout('master') )
@section('title', $page_title)
@section('meta_tags')
    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('page.about')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $seo_metadata['meta_title'] ?? $page_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.about')) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $seo_metadata['meta_title'] ?? $page_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}" />
    @endif

    @php $site_settings = get_site_settings(); @endphp
    @if( isset($site_settings['sites']) && isset($site_settings['sites']['share_logo']) )
        <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}" />
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}" />
    @endif
@endsection
@section('content')
    @php
        $about = $data->extras;
    @endphp
    <section class="about">
        <div class="custom-container">
            <div class="row">
                <div class="col-md-12">
                    <h2>ABOUT US</h2>
                </div>
            </div>
            @if(!empty($about['about']))
            <div class="row">
                <div class="col-md-9">
                    <div class="content-box">
                        @if(isset($about['about']['problem']))
                            <h3>The Problem:</h3>
                            <p>{{$about['about']['problem']}}</p>
                        @endif
                    </div>
                    <div class="content-box">
                        @if(isset($about['about']['what_we_are']))
                            <h3>What We Are :</h3>
                            <p>{{$about['about']['what_we_are']}}</p>
                        @endif

                    </div>
                    <div class="content-box">
                        @if(isset($about['about']['what_we_are_not']))
                            <h3>What We Are Not :</h3>
                            <p>{{$about['about']['what_we_are_not']}}</p>
                        @endif

                    </div>
                    <div class="content-box">
                        @if(isset($about['about']['why_did_we_do_this']))
                            <h3>Why did we do this?</h3>
                            <p>{{$about['about']['why_did_we_do_this']}}</p>
                        @endif

                    </div>
                </div>
                <div class="col-md-3">
                    <div class="ads-img">
{{--                        <img src="{{asset(front_asset('images/vertical-ads.webp'))}}" alt="Vertical Ads">--}}
                    </div>
                    <div class="ads-img">
{{--                        <img src="{{asset(front_asset('images/horizontal-ads.webp'))}}" alt="Horizontal Ads">--}}
                    </div>
                </div>
            </div>
            <div class="row iconbox">
                @if(isset($about['about']['vision']))
                    <div class="col-md-4">
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/vision.webp'))}}" alt="Vision">
                            </div>

                            <h4>Our Vision:</h4>
                            <p>{{$about['about']['vision']}}</p>

                        </div>
                    </div>
                @endif
                @if(isset($about['about']['mission']))
                    <div class="col-md-4">
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/mission.webp'))}}" alt="Mission">
                            </div>
                            <h4>Our Mission:</h4>
                            <p>{{$about['about']['mission']}}</p>
                        </div>
                    </div>
                @endif
                @if(isset($about['about']['values']))
                    <div class="col-md-4">
                        <div class="box">
                            <div class="img">
                                <img src="{{asset(front_asset('images/values.webp'))}}" alt="Values">
                            </div>
                            <h4>Our Values:</h4>
                            <p>{{$about['about']['values']}}</p>
                        </div>
                    </div>
                @endif
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="content-box">
                        @if(isset($about['about']['work_in_progress']))
                            <h3>Work in Progress:</h3>
                            <p>{{$about['about']['work_in_progress']}}</p>
                        @endif
                    </div>
                    <div class="content-box">
                        @if(isset($about['about']['why_a_panda']))
                            <h3>Why a Panda? (We are glad you asked.)</h3>
                            <p>{{$about['about']['why_a_panda']}}</p>
                        @endif
                    </div>
                </div>
            </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <h2 style="text-decoration: none;">Comming Soon</h2>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
