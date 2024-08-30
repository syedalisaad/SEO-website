@extends( admin_layout('auth') )
@section('title', 'Login')
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
                <h3 class="mt-4 mb-2 text-center">{{ admin_heading() }} Login</h3><br>

                @include( admin_view('partials.simple-messages') )
                @php $email = ($_SERVER['HTTP_HOST']=='localhost'?'admin@koderlabs.com':null); @endphp

                <form method="POST" action="{{ route(admin_route('authorize.login')) }}">
                    @csrf
                    <div class="input-group mb-3 {{ (old('email')??$email) ? 'float' : '' }}">
                        <label class="abs-float">Email address<span class="text-denger font-weight-bold">*</span></label>
                        <input type="text" class="form-control @error('email') is-invalid @enderror" name="email"  value="{{ old('email') ?: $email }}" autofocus />
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                        </div>
                        @error('email')
                            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="input-group mb-3">
                        <label class="abs-float">Password <span class="text-denger font-weight-bold">*</span></label>
                        <input type="password" class="form-control  @error('password') is-invalid @enderror"  name="password" autocomplete="current-password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                        @error('password')
                            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="icheck-primary">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                        </div>
                    </div>

                </form>

                <div class="row forget">
                    <p class="mb-1 col-5">
                        <a href="{{ route( admin_route('reset') ) }}">Forgot Password?</a>
                    </p>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    if( performance.navigation.type == 2) {
        window.reload();
    }
    window.onload = (event) => {
        $('[name="email"]').click();
    };



</script>
@endpush
