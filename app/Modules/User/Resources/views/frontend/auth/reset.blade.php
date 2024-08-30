@extends( front_layout('master') )
@section('title', 'Forgot Password')
@section('content')


    <div class="loginpage">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="login">
                        @include( admin_view('partials.simple-messages') )

                        <div class="heading">
                            <h3>Forget Password</h3>
                        </div>
                        <form method="POST" action="{{ route(front_route('user.forgot')) }}">
                            @csrf
                            <p>Please enter your e-mail address to verify, once your e-mail is verified we will send you a link on your registered email address to update your new password.</p>
                            <div class="field">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') ?: '' }}" autofocus/>
                                @error('email')
                                <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="button">
                                <button type="submit" >{{ __('Verify') }}</button>
                                <a href="{{ route( front_route('user.login') ) }}">
                                <button  type="button">Login</button>
                                </a>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>





@endsection
@push('scripts')

@endpush
