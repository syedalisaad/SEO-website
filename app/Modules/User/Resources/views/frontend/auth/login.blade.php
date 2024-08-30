@extends( front_layout('master') )
@section('title', 'Login')
@section('content')

    <div class="loginpage">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="login login-fb-01">
                        <div class="heading">
                            <h3>Login</h3>
                        </div>

                        @include( admin_view('partials.simple-messages') )

                        <form method="POST" action="{{ route(front_route('user.login')) }}">
                            @csrf
                            <div class="field">
                                <input type="email" class=" @error('email') is-invalid @enderror" name="email" required value="{{ old('email') ?: '' }}" placeholder="Email"/>
                                @error('email')<span class="control error invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="field">
                                <input type="password" class="  @error('password') is-invalid @enderror"  placeholder="Password" required name="password" autocomplete="current-password">
                                @error('password')<span class="error invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                            </div>
                            <div class="icheck-primary">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">{{ __('Remember Me') }}</label>
                            </div>
                            <div class="forgot-pass">
                                <a href="{{  route(front_route('user.forgot') ) }}">Forgot Password?</a>
                            </div>
                            <div class="button">
                                <button type="submit" name="login" value="Login">{{ __('Login') }}</button>
                                <a href="{{ route(front_route('user.register')) }}" class="login_reg">
                                    <button type="button">New Hospital Users</button>
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
    <script>
        if (performance.navigation.type == 2) {
            window.reload();
        }
    </script>
@endpush
