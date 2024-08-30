@extends( front_layout('master') )
@section('title','Reset Password')
@section('content')


    <div class="loginpage">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="login">
                        @include( admin_view('partials.simple-messages') )

                        <div class="heading">
                            <h3 class="text-center">Reset Your Password</h3>
                        </div>
                        <form method="POST" action="{{ route(front_route('user.reset.savednewpassword'), $reset->token) }}">
                            @csrf
                            <div class="field">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="{{ __('New Password') }}" value="{{ old('password') ?: '' }}" autofocus/>
                                @error('password')
                                <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="field">
                                <input type="password" class="form-control @error('repeat_password') is-invalid @enderror" name="repeat_password" placeholder="{{ __('Repeat Password') }}" value="{{ old('repeat_password') ?: '' }}" autofocus/>
                                @error('repeat_password')
                                <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="button">
                                <button type="submit">{{ __('Change Password') }}</button>
                            </div>

                        </form>
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
