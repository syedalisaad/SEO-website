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

    <meta property="url" content="{{ route(front_route('page.hospital.list')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $meta_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.hospital.list')) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $meta_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}" />
    @endif

    @if( isset($site_settings['sites']) && isset($site_settings['sites']['share_logo']) )
        <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}" />
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['share_logo']) ?: front_asset('images/logo.png')) }}" />
    @endif
@endsection
@push('styles')
<style>
        @media screen and (min-width: 1366px) and (max-width: 1600px) {
            .map-div-container {
                max-height: 200px;
            }
        }

        pagination {
            width: 100%;
        }

        pagination ul {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        pagination ul li:first-child, pagination ul li:last-child {
            width: 50px;
            height: 30px;
            background: #133c8a;
            border: none;
            color: #fff;
            border-radius: 3px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        pagination ul li:first-child span, pagination ul li:last-child a {
            font-size: 20px;
            font-weight: 900;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            top: -1px;
        }

        pagination ul li span, pagination ul li a {
            font-family: 'open sans';
            font-size: 20px;
            line-height: 27px;
            color: #18418f;
            margin: 0 5px;
            transition: all 0.5s ease;
        }

        pagination ul li.active span {
            font-weight: bold;
        }
    </style>
@endpush
@section('content')

    <section class="map-sec">
        <button id="geoBtn" style="display: none" >GEO</button>
        <div class="detail-sec ">

            <div class="showall">
                showing&nbsp;  <current></current>&nbsp; of &nbsp; <all></all>&nbsp; hospitals
            </div>
            <div class="user-location">
                <i class="far fa-compass-slash"></i>  <current></current>
            </div>
            <div class="list-view">
                <button class="filterbtn btn"><i class="fas fa-filter"></i> Filter</button>
                <a><i class="fas fa-map-marker-alt"></i> <span class="mapview">map</span><span class="listshow listview">list</span></a>
            </div>
            <div class="scroll-mob main" id="contents">

            </div>

            <div class="pagination-list-main ">
                <div class="pagination pagination-list"></div>
            </div>

        </div>
        <div class="map-area">
            <div id="map"></div>
        </div>

        <div class="mob-listing">
            <div class="scroll-tab" id="mobile-contents">
            </div>
            <div class="pagination pagination-map"></div>
        </div>
    </section>

    <div class="page-load">
        <div class="spinner-border"></div>
    </div>

@endsection
@push('scripts')
{{--    <script src="{{ asset(front_asset('js/scrollify.min.js'))}}"></script>--}}
   {{-- <script type="text/javascript">
        var lang = 'en';
        var route_ajax_map = '{{ route(front_route('page.map.hospitals')) }}';
        var marker_map_hover = '{{ asset(front_asset('images/MapMarkerS.svg')) }}';
        var marker_map = '{{ asset(front_asset('images/MapMarkerL.svg')) }}';
        var marker_map_hover_2digit = '{{ asset(front_asset('images/map-marker.svg')) }}';
        var marker_map_2digit = '{{ asset(front_asset('images/map-marker1.svg')) }}';

    </script>
    <script src="{{ asset(front_asset('js/map.js?v=2.4'))}}"></script>--}}
@endpush
