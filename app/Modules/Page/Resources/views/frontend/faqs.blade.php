@php
    $site_settings  = get_site_settings();
    $meta_title     = $seo_metadata['meta_title'] ?? 'FAQ\'s';
@endphp
@extends( front_layout('master') )
@section('title', 'FAQ\'s')
@section('meta_tags')
    @if( isset($seo_metadata['meta_keywords']) && $seo_metadata['meta_keywords'] )
        <meta name="keywords" content="{{ $seo_metadata['meta_keywords'] }}"/>
    @endif

    <meta property="url" content="{{ route(front_route('page.faq')) }}" />
    <meta property="type" content="article" />
    <meta property="title" content="{{ $meta_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="description" content="{{ $seo_metadata['meta_description'] }}"/>
    @endif

    <meta property="og:url" content="{{ route(front_route('page.faq')) }}" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{ $meta_title }}" />
    @if( isset($seo_metadata['meta_description']) && $seo_metadata['meta_description'] )
        <meta property="og:description" content="{{ $seo_metadata['meta_description'] }}" />
    @endif

    @if( isset($site_settings['sites']) && isset($site_settings['sites']['site_logo']) )
        <meta property="image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: front_asset('images/logo.png')) }}" />
        <meta property="og:image" content="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: front_asset('images/logo.png')) }}" />
    @endif
@endsection
@section('content')

    <section class="faqs faqpage">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>FAQs</h2>

                    @php
                        $faq_count=0;
                       if ( isset( $data ) && isset($data->extras['faq'][0]['name']) ) {
                           $faqs      = $data->extras['faq'];
                           $faq_count = count( $faqs );
                           $no =1;
                       }

                    @endphp
                    <div id="accordion" class="accordion-container">
                        @if($faq_count!=0)
                            @for($i=0;$i<$faq_count;$i++)

                                <h4 class="accordion-title js-accordion-title" id="faq-{{$no}}">{{$no++}}. {{ $faqs[$i]['name']}}</h4>
                                <div class="accordion-content">
                                    <p>{{ $faqs[$i]['content']}}</p>
                                </div>
                            @endfor
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <h2 style="text-decoration: none;">Comming Soon</h2>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@push('scripts')
    <script>
        function getURLParameter(e) {
            return decodeURI((new RegExp(e + "=(.+?)(&|$)").exec(location.search) || [, ""])[1]);
        }
        $(document).ready(function (){
            if(getURLParameter('faq')) {
                $('.accordion-title').removeClass('open');
                $('.accordion-content').hide();
                $('#faq-' + getURLParameter('faq')).addClass('open');
                $('#faq-' + getURLParameter('faq')).next().show();
            }

            $('html, body').animate({
                scrollTop:  $('#faq-' + getURLParameter('faq')).offset().top}, 0,);
            });
    </script>
@endpush


