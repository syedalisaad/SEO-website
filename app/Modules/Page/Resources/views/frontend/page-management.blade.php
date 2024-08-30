@php
    $site_settings  = get_site_settings();
    $meta_title     = $seo_metadata['meta_title'] ?? $page_title;
@endphp
@extends( front_layout('master') )
@section('title', $page_title)
@section('meta_tags')
    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('page.management'), [$data->slug]) }}"/>
    <meta property="type" content="article"/>
    <meta property="title" content="{{ $meta_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.management'), [$data->slug]) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $meta_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    @if( isset($site_settings['sites']) && isset($site_settings['sites']['share_logo']) )
        <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}" />
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}" />
    @endif
@endsection
@section('content')

    <main style="margin-top: 80px">
        <section class="termsPage">
            <div class="container-fluid p-4">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="page-header">
                            <h2 class="pageheader-title">{{ $page_title }}</h2>
                            <div class="page-breadcrumb">
                                <nav aria-label="breadcrumb"><ol class="breadcrumb"></ol></nav>
                            </div>
                            <br>
                            @if( $data->page_header_sub_title )
                                <p class="lead">{!! $data->page_header_sub_title !!}</p>
                            @endif
                            <br>

                            {!! $data->description !!}

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

@endsection
