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

    <meta property="url" content="{{ route(front_route('page.terms')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $meta_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.terms')) }}" />
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
@section('content')
    @php
        $terms = $data->extras;
    @endphp

    <section class="privacy">
        <div class="custom-container">
            @if(!empty($data->description))
                <div class="row">
                    <div class="col-md-12">
                        <h2>TERMS OF SERVICE</h2>
                        <p>{!! $data->description??'' !!}</p>
                    </div>

                    <!-- <div class="row"> -->
                        <div class="col-md-12">
                            <?php
                            $terms_count = 0;
                            if ( isset( $data ) && isset( $data->extras['terms'][0]['name'] ) ) {
                                $terms       = $data->extras['terms'];
                                $terms_count = count( $terms );
                                $no          = 1;
                            }

                            ?>
                            @for($i=0;$i<$terms_count;$i++)

                                <div class="pri-box" {{$no==3?"id=dp" : ''}} {{$no==1?"id=rf" : ''}}>

                                    <h4><span>{{$no}}</span>{{$data->extras['terms'][$i]['name']}}</h4>
                                    <!-- <div class="flex-fill"> -->
                                        {!! $data->extras['terms'][$i]['content']  !!}
                                    <!-- </div> -->

                                </div>
                                    <?php $no++; ?>
                            @endfor


                        <!-- </div> -->
                    </div>

                </div>
            @else
                <div class="row">
                    <div class="col-md-12">
                        <h2>TERMS OF SERVICE</h2>
                    </div>
                    <div class="col-md-12">
                        <h2 style="text-decoration: none;">Comming Soon</h2>
                    </div>
                </div>
            @endif
        </div>
    </section>

@endsection
