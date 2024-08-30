@extends( front_layout('master') )
@section('title', '404')
@section('content')

{{--    <section class="error-page">--}}
{{--        <div class="custom-container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <i class="fas fa-exclamation-triangle"></i>--}}
{{--                    <h2>404</h2>--}}
{{--                    <p>Page not found</p>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </section>--}}

<section class="error-page">
    <div class="custom-container">
        <div class="row align-items-center">
            <div class="col-md-6">
{{--                <h2>404</h2>--}}
                <h4>Oops! Page not found</h4>
                <p>The page you are looking for does not exist. </p>
                <a href="" class="btns">Go Home</a>
            </div>
            <div class="col-md-6">
                <div class="img">
                    <img src="{{asset(front_asset('images/404.png'))}}">
                </div>
            </div>
        </div>

    </div>
</section>

@endsection



