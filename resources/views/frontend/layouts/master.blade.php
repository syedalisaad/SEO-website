<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_favicon']) ?: '/'.front_asset('images/favicon.png')) }}" type="image/gif">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="base-url" content="{{ url('/') }}"/>
    <meta name="google-api-key" content="{{ env('GOOGLE_API_KEY')}}"/>
    <link rel="stylesheet" href="{{ asset( front_asset('css/style.css?v=2.6')) }}"/>
    <link rel="stylesheet" href="{{ asset( front_asset('css/responsive.css?v=2.9')) }}"/>
    <link rel="stylesheet" href="{{ asset( front_asset('css/slick.css')) }}"/>
    <link rel="stylesheet" href="{{ asset( front_asset('css/slick-theme.css')) }}"/>
    @if(null !== (\Request::route()) && \Request::route()->getName()!='home')
        <link rel="stylesheet" type="text/css" href="{{ asset( front_asset('/css/jquery.raty.css'))}}">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css"/>
    @yield('meta_tags')
    @stack('styles')
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7665968815871292" crossorigin="anonymous"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-213356344-1">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'UA-213356344-1');
    </script>
</head>

<body>

<div class="loading const-spinner" id="const-spinner" style="width: 100%; height: 100%; position: fixed; background: rgb(0 0 0 / 50%); z-index: 99; display: flex; align-items: center; justify-content: center;">
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto;display: block;shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <circle cx="50" cy="50" r="0" fill="none" stroke="#6356e6" stroke-width="2">
            <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.5s"/>
            <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.5s"/>
        </circle>
        <circle cx="50" cy="50" r="0" fill="none" stroke="#cb5ce0" stroke-width="2">
            <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline"/>
            <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline"/>
        </circle>
    </svg>
</div>

@if(isset($site_settings['announcements']['announcement_text'], $site_settings['announcements']['start_date'], $site_settings['announcements']['status']) )

    @php
        $date_now     = date("Y-m-d");
        $start_date   = $site_settings['announcements']['start_date'] ?: null;
        $end_date     = $site_settings['announcements']['end_date'] ?? null;
    @endphp
    @if( (!$end_date && $start_date <= $date_now) || ($end_date && $date_now <= $end_date))
        <div class="announcement">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p>{!! $site_settings['announcements']['announcement_text'] !!}</p>
                    </div>
                </div>
            </div>
            <i class="far fa-times-circle"></i>
        </div>

    @endif
@endif

<header id="header">
    <div class="custom-container">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="toggle-close">
                        <i class="far fa-times-circle"></i>
                    </div>
                    <div class="footer-sidebar-logo">
                        <a href="{{ url('/') }}">
                            <img
                                src="{{ isset($site_settings['sites']['site_logo_footer']) ? ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo_footer']) ?: '/'.front_asset('images/logo.png')):'' }}"
                                alt="{{ $site_settings['sites']['site_name'] }}"/>
                        </a>
                    </div>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ route(front_route('page.hospital.list')) }}">Hospitals Near Me</a></li>
                        <li><a href="{{ route(front_route('page.national.national_avarages')) }}">National Averages</a></li>
                        <li><a href="{{ route(front_route('page.faq')) }}">FAQs</a></li>
                        <li><a href="{{ route(front_route('page.about')) }}">About Us</a></li>
                        <li><a href="{{ route(front_route('blog.index')) }}">Blogs</a></li>
                        <li><a href="{{ route(front_route('page.email')) }}">Email Updates</a></li>
                        <li>
                            @if(auth()->check())
                                <div class="dash-head">

                                    <div class="profile">
                                        <div class="img">
                                            <img src="{{auth()->user()->image_url??asset(front_asset('images/dash-pro.png'))}}">
                                        </div>
                                        <div class="pro-name">{{auth()->user()->first_name.' '.auth()->user()->last_name}}</div>
                                        <div class="{{auth()->user()->is_active==1 ? 'active-status' : 'deactive-status'}}">
                                            <i class="fas fa-circle"></i>
                                        </div>
                                    </div>
                                </div>
                                <ul class="innerul">
                                    <li><a href="{{ route(front_route('user.dashboard')) }}" class="{{'front.user.dashboard' == Route::currentRouteName()?'active':''}}">Dashboard</a></li>
                                    <li><a href="{{ route(front_route('user.logout')) }}">Logout</a></li>
                                </ul
                            @else
                                <a href="{{ route(front_route('user.register')) }}" class="btn">For Hospitals</a>

                            @endif


                        </li>
                        {{--                    <li><a href="#" class="btn">For Hospitals</a></li>--}}
                    </ul>
                </nav>
            </div>
            <div class="onlymobile">
                <div class="img">
                    @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
                        <a href="{{ url('/') }}">
                            <img
                                src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: '/'.front_asset('images/logo.png')) }}"
                                alt="{{ $site_settings['sites']['site_name'] }}"/>
                        </a>
                    @endif
                </div>
                <div class="toggle">
                    <i class="fas fa-bars"></i>
                </div>
            </div>
        </div>
    </div>
</header>
@if('front.page.hospital.list' == Route::currentRouteName())
    <!------ Near me search ---->
    @include(front_layout('search-template'))
    <!------ Near me search ---->
@else
    @if((isset($banner) && $banner == 2) || ('front.user.dashboard' == Route::currentRouteName()))

    @elseif(isset($banner) && $banner == 1)
        <div class="innerbanner">
            <div class="custom-container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="img">
                            @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
                                <a href="{{ url('/') }}">
                                    <img
                                        src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: '/'.front_asset('images/logo.png')) }}"
                                        alt="{{ $site_settings['sites']['site_name'] }}"/>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <form class="mainsearch const-hospital-form" action="#"
                              data-action="{{ route(front_route('page.hospital.list')) }}">
                            <div class="search">
                                <select class="select2" style="width: 100%;">
                                </select>
                                <input class="select2-selection__rendered_show" value="{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}" hidden style="width: 100%;">
                                <input class="seach_name_value" value="{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}" name="name" hidden style="width: 100%;">

                            </div>
                            <div class="spann-or">OR</div>
                            <div class="zipcode">
                                <input type="text"   name="zipcode" class="pac-input" placeholder="Start with 3 digits of Zipcode" value="{{request()->get('zipcode')??''}}">
                                <input type="hidden" name="zipcode_hidden" value="{{request()->get('zipcode_hidden')??''}}">

                                <i class="far fa-compass"></i>
                            </div>
                            <input type="button" name="submit" value="Search" class="btn const-search-hospitals">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <section class="homebanner">
            <div class="custom-container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="img">
                            @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
                                <a href="{{ url('/') }}">
                                    <img
                                        src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: '/'.front_asset('images/logo.png')) }}"
                                        alt="{{ $site_settings['sites']['site_name'] }}"/>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-8">
                        <h2>Find Hospitals near you</h2>
                        <p><a class="btn custom-btn" href="{{ route(front_route('page.hospital.list')) }}">Start Your Search Now! </a></p>
                        <form class="mainsearch const-hospital-form"  action="#"
                              data-action="{{ route(front_route('page.hospital.list')) }}">
                            <div class="search">
                                <select class="select2" style="width: 100%;">
                                </select>
                                <input class="select2-selection__rendered_show" value="{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}"  hidden style="width: 100%;">
                                <input class="seach_name_value" value="{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}" name="name" hidden style="width: 100%;">

                            </div>
                            <div class="spann-or">OR</div>
                            <div class="zipcode">
                                <input type="text"  maxlength="5" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"    name="zipcode" class="pac-input"  placeholder="Start with 3 digits of Zipcode" value="{{request()->get('zipcode')??''}}">
                                <input type="hidden" name="zipcode_hidden" value="{{request()->get('zipcode_hidden')??''}}">
                                <i class="far fa-compass"></i>
                            </div>
                            <input type="button" name="submit" value="Search" class="btn const-search-hospitals">
                        </form>
                    </div>
                </div>

            </div>
        </section>
    @endif

@endif
@yield('content')

<footer>

    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="img">
                    @if( isset($site_settings['sites']) && isset($site_settings['sites']['site_logo_footer']) )
                        <a href="{{ url('/') }}">
                            <img
                                src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo_footer']) ?: '/'.front_asset('images/logo.png')) }}"
                                alt="{{ $site_settings['sites']['site_name'] }}"/>
                        </a>
                    @endif
                </div>
                @if( isset($site_settings['sites']['footer_about'] ) && $site_settings['sites']['footer_about'] )
                    {!! $site_settings['sites']['footer_about'] !!}
                @endif
            </div>
            <div class="col-md-2">
                <h5>Quick Links</h5>
                <ul class="fnav">
                    <li><a href="{{ route(front_route('page.hospital.list')) }}">Hospitals Near Me</a></li>
                    <li><a href="{{route(front_route('page.privacy_policy'))}}">Privacy Policy</a></li>
                    <li><a href="{{route(front_route('page.terms')).'/#dp'}}">Delivery Policy</a></li>
                    <li><a href="{{route(front_route('page.terms')).'/#rf'}}">Refund Policy</a></li>
                    <li><a href="{{ route(front_route('page.email')) }}">Email Updates</a></li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5>Quick Links</h5>
                <ul class="fnav">
                    <li><a href="{{route(front_route('page.terms'))}}">Terms of Use</a></li>
                    <li><a href="{{ route(front_route('page.faq')) }}">FAQs</a></li>
                    <li><a href="{{ route(front_route('page.about')) }}">About Us</a></li>
                    <li><a href="{{ route(front_route('blog.index')) }}">Blogs</a></li>
                    <li><a href="{{ route(front_route('page.contact')) }}">Contact Us</a></li>
                    <li><a href="{{ route(front_route('user.login')) }}">Partnerships</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Subscribe</h5>
                <form method="POST" action="#" class="newsletter" id="newsletters"
                      data-action="{{ route( front_route('page.newsletter')) }}">
                    <input type="email" name="email" placeholder="Email">
                    <input type="submit" name="send" value="Submit">
                    <div class="response_msg w-100 text-center"></div>
                    <!-- <div class="col-lg-12">

                    </div> -->
                </form>
                <ul class="social-nav">
                    @if( isset($site_settings['social_links']['facebook']) && $site_settings['social_links']['facebook'] )
                        <li><a href="{{$site_settings['social_links']['facebook']}}" target="_blank"><i
                                    class="fa fa-facebook-official"></i></a></li>
                    @endif
                    @if( isset($site_settings['social_links']['twitter']) && $site_settings['social_links']['twitter'] )
                        <li><a href="{{$site_settings['social_links']['twitter']}}" target="_blank"><i
                                    class="fa fa-twitter-square"></i></a></li>
                    @endif
                    @if( isset($site_settings['social_links']['instagram']) && $site_settings['social_links']['instagram'] )
                        <li><a href="{{$site_settings['social_links']['instagram']}}" target="_blank"><i
                                    class="fa fa-instagram"></i></a></li>
                    @endif
                    @if( isset($site_settings['social_links']['youtube']) && $site_settings['social_links']['youtube'] )
                        <li><a href="{{$site_settings['social_links']['youtube']}}" target="_blank"><i
                                    class="fa fa-youtube-play"></i></a></li>
                    @endif
                    @if( isset($site_settings['social_links']['linkedin']) && $site_settings['social_links']['linkedin'] )
                        <li><a href="{{$site_settings['social_links']['linkedin']}}" target="_blank"><i
                                    class="fa fa-linkedin"></i></a></li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</footer>

<div class="copyryt">
    <div class="container">
        @if( isset($site_settings['sites']['footer_text']) && $site_settings['sites']['footer_text'] )
            <div class="row">
                <div class="col-md-12">
                    <p>{{ $site_settings['sites']['footer_text'] }}</p>
                </div>
            </div>
        @endif
    </div>
    <a class="scroll-top" href="#header">
        <i class="fas fa-arrow-circle-up"></i>
    </a>
</div>


@stack('modals')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="{{ asset(front_asset('js/slick.js')) }}"></script>
@if(null !== (\Request::route()) && \Request::route()->getName()!='home')
<script src="{{ asset(front_asset('js/jquery.raty.js'))}}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
@endif

<script src="{{ asset(front_asset('js/labs.js'))}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://kit.fontawesome.com/d778189688.js"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<script type="text/javascript" src="{{ asset(front_asset('js/custom.js?v=3')) }}"></script>
<script type="text/javascript" src="{{ asset(front_asset('js/build-scripts.js?v=2.8')) }}"></script>
<link rel="stylesheet" href="{{ asset( front_asset('css/select2.min.css')) }}"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

<script>
    $(document).ready(function () {



        $loading = $('#const-spinner');
        $loading.hide();

        $("form").on('submit', function () {

            $loading.show();

            setTimeout(function () {
                return true;
            }, 1000)
        });

        $(document)
            .ajaxStart(function () {
                $loading.show();
            })
            .ajaxStop(function () {
                $loading.hide();
            });
        @if(null !== (\Request::route()) && \Request::route()->getName()!='home')
        $('.chart').each(function () {
            var ctx = $(this);
            always = $(this).data("always")
            someties = $(this).data("sometimes")
            usually = $(this).data("usually")
            var chart = new Chart(ctx, {
                type: 'pie',

                data: {
                    datasets: [{
                        data: [always, someties, usually],
                        // label: [always+'%', someties+'%', usually+'%'],
                        backgroundColor: ['#00AF50', '#FFC000', '#FF3131'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    showTooltips: false,

                    plugins: {
                        tooltip: {
                            showTooltips: true,
                            callbacks: {
                                label: function (context) {
                                    var label = context.formattedValue + '%' || '';
                                    console.log('context', context);
                                    console.log('labell', label);
                                    return label;
                                }
                            }
                        }
                    }
                }
            });
        });

        @endif
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('.select2').change(function () {
            select2 = $(this).val();
            $('.select2-selection__rendered_show').val(select2);
            $('.seach_name_value').val(encodeURIComponent(select2));

        })
        var getValue = "{{request()->get('hospital')??'0'}}";
        if (getValue != 0) {
            var $newOption = $("<option selected='selected'></option>").val("{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}").text("{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}")

            $("select.select2").append($newOption).trigger('change');
        }


        $("select.select2").select2({
            width: 'resolve',

            placeholder: "Select Hospital",
            minimumInputLength: 2,
            allowClear: true,
            name: 'hospital',
            ajax: {
                url: "{{route(front_route('page.facility_name_ajax'))}}",
                dataType: 'json',

                processResults: (data, params) => {
                    const results = data.items.map(item => {
                        return {
                            id: item.facility_name,
                            text: item.facility_name,
                        };
                    });
                    return {
                        results: results,
                    }
                },
            },
        });


        $("select.register_hospital_name").select2({
            width: 'resolve',

            placeholder: "Select Hospital",
            minimumInputLength: 2,
            allowClear: true,
            name: 'hospital',
            ajax: {
                url: "{{route(front_route('page.facility_name_ajax'))}}",
                dataType: 'json',

                processResults: (data, params) => {
                    const results = data.items.map(item => {
                        return {
                            id: item.id,
                            text: item.facility_name,
                        };
                    });
                    return {
                        results: results,
                    }
                },
            },
        });


        @if(Route::is(front_route('page.hospital.list')))
        $('#searchform').on('submit', function (e) {
            // validation code here
            e.preventDefault();
            navigator.geolocation.getCurrentPosition(geoPositionSuccess, geoPositionError, geoPositionOptions);
        });
        @endif
    });

    $('.select2-search__field').val('{!! request()->get('hospital')?utf8_decode(request()->get('hospital')):'' !!}')

    function formatPhoneNumber(phoneNumberString) {
        var cleaned = ('' + phoneNumberString).replace(/\D/g, '');
        var match = cleaned.match(/^(\d{3})(\d{3})(\d{4})$/);
        if (match) {
            return '+1 (' + match[1] + ') ' + match[2] + '-' + match[3];
        }
        return null;
    }
    @if(null !== (\Request::route()) && \Request::route()->getName()!='home')
    function starRating() {
        jQuery('.stars').raty({
            half: true,
            path: null,
            score: function () {
                return $(this).attr('data-rating');
            },
            readOnly: function () {
                return true;
            },
            starHalf: '{{asset(front_asset('images/yellowhalf.webp'))}}',
            starOff: '{{asset(front_asset('images/yellowunfill.webp'))}}',
            starOn: '{{asset(front_asset('images/yellowfill.webp'))}}'
        });
        jQuery('.blackstars').raty({
            path: null,
            score: function () {
                return $(this).attr('data-rating');
            },
            readOnly: function () {
                return true;
            },
            starOff: '{{asset(front_asset('images/blackunfill.webp'))}}',
            starOn: '{{asset(front_asset('images/blackfill.webp'))}}'
        });
    }

    starRating();
    @endif

    if (localStorage.getItem('hospital')) {
        let href = $('.back_near_me').attr('href');
        $('.back_near_me').attr('href', href + '?hospital=' + localStorage.getItem('hospital'))
    }

    @if(isset($end_date) && $end_date!=null && $date_now >= $end_date)
    if (localStorage.getItem("announcement_close")) {
        localStorage.removeItem("announcement_close")
    }
    @endif

</script>
<script type="text/javascript">
    var lang = 'en';
    var route_ajax_map = '{{ route(front_route('page.map.hospitals')) }}';
    var marker_map_hover = '{{ asset(front_asset('images/MapMarkerS.svg')) }}';
    var marker_map = '{{ asset(front_asset('images/MapMarkerL.svg')) }}';
    var marker_map_hover_2digit = '{{ asset(front_asset('images/map-marker.svg')) }}';
    var marker_map_2digit = '{{ asset(front_asset('images/map-marker1.svg')) }}';

</script>
<script src="{{ asset(front_asset('js/map.js?v=2.12'))}}"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3&key={{ env('GOOGLE_API_KEY')}}&libraries=places&callback=initialize"></script>

@stack('scripts')
</body>
</html>
