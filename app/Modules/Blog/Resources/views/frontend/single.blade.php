@php
    $site_settings  = get_site_settings();
    $meta_title     = $seo_metadata['meta_title'] ?? $post->name;
@endphp
@extends( front_layout('master') )
@section('title', $post->name)
@section('meta_tags')
    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('blog.single'), $post->slug) }}"/>
    <meta property="type" content="article"/>
    <meta property="title" content="{{ $meta_title }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('blog.single'), $post->slug) }}"/>
    <meta property="og:type" content="article"/>
    <meta property="og:title" content="{{ $post->name }}"/>
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    <meta property="image" content="{{ $post->image_url }}"/>
    <meta property="og:image" content="{{ $post->image_url }}"/>
    <meta property="og:image:url" content="{{ $post->image_url }}"/>
    <meta property="og:image:width" content="200" />
    <meta property="og:image:height" content="200" />
    <meta name="twitter:image:src" content="{{ $post->image_url }}">
    <meta name="twitter:image" content="{{ $post->image_url }}">

@endsection
@section('content')

    <section class="singleblog">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="share float-right " style="padding-bottom: 10px">
                        <a href="#"><i class="fas fa-share-square"></i> Share this Blog</a>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="img">
                        <img id="social_image" src="{{ $post->image_url }}" alt="{{ $post->name }}" style="width: 100%;">
                    </div>
                    <h3>{{ $post->name }}</h3>

                    {!! $post->description !!}
                </div>
            </div>
        </div>
    </section>

    <section class="news">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mb-5">Related Blog</h2>
                </div>
            </div>
            <div class="row">

                @foreach($posts as $key)
                    <div class="col-md-4">
                        <div class="img">
                            <a href="{{route(front_route('blog.single'),$key->slug)}}">
                                <img src="{{ $key->image_url }}" alt="{{ $key->name }}">
                            </a>
                        </div>
                        <h3>{{ $key->name }}</h3>
                        <p>{!! $key->short_desc !!}</p>
                        <a href="{{route(front_route('blog.single'),$key->slug)}}">Read More <i class="fa fa-long-arrow-right"></i></a>
                    </div>
                @endforeach

            </div>
        </div>
    </section>

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
