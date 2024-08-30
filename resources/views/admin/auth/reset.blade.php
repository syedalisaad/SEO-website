@extends( admin_layout('auth') )
@section('title', 'Forgot Password')
@section('content')

    <div class="login-box">

        @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
        <div class="login-logo">
            <a href="{{ url('/') }}">
                <img src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: front_asset('images/logo.png')) }}" class="img-fluid" alt="{{ $site_settings['sites']['site_name'] ?? null }}" />
            </a>
        </div>
        @endif

        <div class="card">
            <div class="card-body login-card-body">

                @include( admin_view('partials.simple-messages') )

                <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                <form method="POST" action="{{ route(admin_route('submit.reset')) }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') ?: '' }}" autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Send password reset email') }}</button>
                        </div>
                    </div>
                </form>

                <div class="row forget">
                    <p class="mb-1 col-5">
                        <a href="{{ route( admin_route('login') ) }}">Login?</a>
                    </p>
                </div>

            </div>
        </div>
    </div>

@endsection
