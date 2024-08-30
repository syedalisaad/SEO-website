@extends( front_layout('master') )
@section('title', 'Email Verification')
@section('content')
    <section class="congo">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Congratulations!</h2>
                    <p>Your Email address has been verified. Soon you will receive the password of your account, once your account gets approved.<br>For more queries, you can<a href="{{route(front_route('page.contact'))}}"> contact us</a>. </p>
                    <a class="butn" href="{{ route(front_route('user.login')) }}">Login</a>
                </div>
            </div>
        </div>
    </section>
@endsection

