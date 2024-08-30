<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_favicon']) ?: '/'.front_asset('images/favicon.png')) }}" type="image/gif">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="base-url" content="{{ url('/') }}" />
    <meta name="google-api-key" content="{{ env('GOOGLE_API_KEY')}}" />
    <script src="https://cdn.tailwindcss.com"></script>
    @if(null !== (\Request::route()) && \Request::route()->getName()!='home')
    <link rel="stylesheet" type="text/css" href="{{ asset( front_asset('/css/jquery.raty.css'))}}">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    @yield('meta_tags')
    @stack('styles')
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-7665968815871292" crossorigin="anonymous"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-213356344-1">
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());

        gtag('config', 'UA-213356344-1');
    </script>
</head>

<body>

    <div class="loading const-spinner" id="const-spinner" style="width: 100%; height: 100%; position: fixed; background: rgb(0 0 0 / 50%); z-index: 99; display: flex; align-items: center; justify-content: center;">
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto;display: block;shape-rendering: auto;" width="200px" height="200px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
            <circle cx="50" cy="50" r="0" fill="none" stroke="#6356e6" stroke-width="2">
                <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" begin="-0.5s" />
                <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" begin="-0.5s" />
            </circle>
            <circle cx="50" cy="50" r="0" fill="none" stroke="#cb5ce0" stroke-width="2">
                <animate attributeName="r" repeatCount="indefinite" dur="1s" values="0;40" keyTimes="0;1" keySplines="0 0.2 0.8 1" calcMode="spline" />
                <animate attributeName="opacity" repeatCount="indefinite" dur="1s" values="1;0" keyTimes="0;1" keySplines="0.2 0 0.8 1" calcMode="spline" />
            </circle>
        </svg>
    </div>

    <header class="flex justify-between items-center text-[16px] px-6 py-4 bg-white font-semibold text-[#222525]">
        <div class="flex gap-12">
            <a href="{{ url('/') }}">
                <img
                    src="{{ isset($site_settings['sites']['site_logo_footer']) ? ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo_footer']) ?: '/'.front_asset('images/logo.png')):'' }}"
                    alt="{{ $site_settings['sites']['site_name'] }}" />
            </a>
            <div class="flex items-center gap-6 pt-2">
                <a href="./pricing.html" class="hover:text-[#fe6100] cursor-pointer">Pricing</a>
                <a class="hover:text-[#fe6100] cursor-pointer">Free Tools</a>
                <a class="hover:text-[#fe6100] cursor-pointer">Articles</a>
            </div>
        </div>
        <div class="flex gap-5 items-center">
            <a class="px-3 py-1 border border-[#e2e8f0] rounded-lg" href="{{ route(front_route('user.login')) }}">Log In</a>
            <a class="px-3 py-1 bg-[#fe6100] text-white rounded-lg" href="{{ route(front_route('user.register')) }}">Start Free Trial</a>
        </div>
    </header>


    @yield('content')
    <footer class="bg-[#001E42] py-[72px]">
        <div class="grid grid-cols-2 !items-start px-[2.75rem]">
            <h1 class="text-[32px] text-white max-w-[70%] leading-[1.2] font-bold mb-[0.75rem]">
                Check your website's SEO for free right now!
            </h1>
            <form class="flex w-full max-w-[55%] ml-auto">
                <div class="relative w-full bg-white rounded-tl-lg rounded-bl-lg overflow-hidden focus:!outline-blue-400 focus:!outline focus:outline-3">
                    <input type="text" placeholder="Website URL"
                        class="w-full px-[1rem] text-xl py-3 focus:outline-none" />
                </div>
                <button type="submit"
                    class="bg-[#FE6100] hover:bg-[#CB4E00] text-white font-bold px-5 text-lg rounded-tr-lg rounded-br-lg">
                    Checkup
                </button>
            </form>
        </div>

        <div class="border-b border-b-[#E2E8F0] my-16 opacity-[0.2]"></div>

        <div class="grid grid-cols-2 !items-start px-[2.75rem]">
            <div>
                @if( isset($site_settings['sites']) && isset($site_settings['sites']['site_logo_footer']) )
                <a href="{{ url('/') }}">
                    <img
                        src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo_footer']) ?: '/'.front_asset('images/logo.png')) }}"
                        alt="{{ $site_settings['sites']['site_name'] }}" class="h-[38px] " />
                </a>
                @endif


                <p class="max-w-[294px] my-[1.5rem] text-white text-[18px] font-bold">
                    @if( isset($site_settings['sites']['footer_about'] ) && $site_settings['sites']['footer_about'] )
                    {!! $site_settings['sites']['footer_about'] !!}
                    @endif
                </p>
                <div class="flex items-center gap-[0.75rem] text-white">
                    @if( isset($site_settings['social_links']['facebook']) && $site_settings['social_links']['facebook'] )
                    <a href="{{$site_settings['social_links']['facebook']}}" target="_blank">
                        <div class="bg-[#334b68] rounded-full flex items-center justify-center h-9 w-9">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 512 512"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                                </path>
                            </svg>
                        </div>
                    </a>
                    @endif
                    @if( isset($site_settings['social_links']['twitter']) && $site_settings['social_links']['twitter'] )
                    <a href="{{$site_settings['social_links']['twitter']}}" target="_blank">
                        <div class="bg-[#334b68] rounded-full flex items-center justify-center h-9 w-9">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 320 512"
                                height="1em" width="1em" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                </path>
                            </svg>
                        </div>
                    </a>
                    @endif
                </div>
            </div>
            <div class="grid grid-cols-3 gap-[2.5rem] ml-auto">
                <div class="">
                    <div class="font-bold leading-[1.5] mb-[0.5rem] text-white">Product</div>
                    <ul role="list" class="text-white">
                        <li class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white">Pricing</li>
                        <li class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white mt-[0.5rem]">Free Tools
                        </li>
                        <li class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white mt-[0.5rem]">Articles
                        </li>

                        <li class="mt-[0.5rem]">
                            <div class="inline-flex">
                                <div class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white" href="{{ route(front_route('user.login')) }}">Login</div>
                            </div>
                        </li>
                        <li class="mt-[0.5rem]">
                            <div class="inline-flex">
                                <div class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white">Free 7-Day
                                    Trial</div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="ml-[1em]">
                    <div class="font-bold leading-[1.5] mb-[0.5rem] text-white">Company</div>
                    <ul role="list" class="text-white">
                        <div>
                            <a href="{{ route(front_route('page.about')) }}"
                                class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white">About us</a>
                        </div>
                        <div class="mt-[0.5rem]">
                            <a href="{{ route(front_route('page.faq')) }}"
                                class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white ">FAQs</a>
                        </div>
                        <div class="mt-[0.5rem]">
                            <a href="./seoCheckup.html"
                                class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white ">SEO
                                Checkups
                            </a>
                        </div>
                        <div class="mt-[0.5rem]">
                            <a href="{{ route(front_route('page.contact')) }}"
                                class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white ">
                                Contact
                            </a>
                        </div>
                    </ul>
                </div>
                <div class="ml-[1em]">
                    <div class="font-bold leading-[1.5] mb-[0.5rem] text-white">Legal</div>
                    <ul role="list" class="text-white">
                        <div>



                            <a href="{{route(front_route('page.terms'))}}"
                                class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white">Terms of
                                Service</a>
                        </div>
                        <div class="mt-[0.5rem]">

                            <a href="{{route(front_route('page.privacy_policy'))}}"
                                class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white ">Privacy
                                Policy</a>
                        </div>
                        <div class="mt-[0.5rem]">

                            <a href="{{route(front_route('page.terms')).'/#rf'}}"
                                class="font-semibold cursor-pointer text-[#BFC7D0] hover:text-white ">Refunds
                                Policy</a>
                        </div>
                    </ul>
                </div>
            </div>
        </div>

        <div class="pl-[2.75rem] text-white mt-[5rem]">© SEO Site Checkup 2020-2024 • All rights reserved</div>
    </footer>
    <footer>

        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="img">

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
    <link rel="stylesheet" href="{{ asset( front_asset('css/select2.min.css')) }}" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script>
    
    @stack('scripts')
</body>

</html>