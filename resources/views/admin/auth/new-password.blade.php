@extends( admin_layout('auth') )
@section('title', 'Reset New Password')
@section('content')

    <div class="login-box">

        @if( isset($site_settings['sites']) && $site_settings['sites']['site_logo'] )
            <div class="login-logo">
                <a href="{{ url('/') }}">
                    <img src="{{ ( \App\Models\Setting::getImageURL( $site_settings['sites']['site_logo']) ?: front_asset('images/logo.png')) }}" class="img-fluid" alt="{{ $site_settings['sites']['site_name'] ?? null }}"/>
                </a>
            </div>
        @endif

        <div class="card">
            <div class="card-body login-card-body">

                @include( admin_view('partials.simple-messages') )

                <h3 class="text-center">Reset Your Password</h3>
                <p class="login-box-msg">Please choose a new password to finish signing in.</p>

                <form method="POST" action="{{ route(admin_route('reset.savednewpassword'), $reset->token) }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="{{ __('New Password') }}" value="{{ old('new_password') ?: '' }}" autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-key"></span></div>
                        </div>
                        @error('new_password')
                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('repeat_password') is-invalid @enderror" name="repeat_password" placeholder="{{ __('Repeat Password') }}" value="{{ old('repeat_password') ?: '' }}" autofocus/>
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-key"></span></div>
                        </div>
                        @error('repeat_password')
                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Change Password') }}</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
