@extends( front_layout('master') )
@section('title', 'Dashboard')
@section('content')

    <div class="dashboard">

        <div class="dash-side">
            @include( frontend_module_view('partials.sidebar') )
        </div>

        <div class="dash-data">

            <div class="loginpage">
                <div class="dash-detial">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="page-title">
                                Change Password
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="dashboard_change_password">
                            @include( admin_view('partials.simple-messages') )

                            <!-- <div class="heading">
                                    <h3>Reset Password</h3>
                                </div> -->
                                <form method="POST" class="dash-upload" action="{{ route(front_route('user.reset.change_password')) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="dash-label">New Password</label>
                                        <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" placeholder="{{ __('New Password*') }}" value="{{ old('new_password') ?: '' }}" autofocus/>
                                        @error('new_password')
                                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="dash-label">Confirm Password</label>
                                        <input type="password" class="form-control @error('confirm_passowrd') is-invalid @enderror" name="confirm_passowrd" placeholder="{{ __('Confirm Password*') }}" value="{{ old('confirm_passowrd') ?: '' }}" autofocus/>
                                        @error('confirm_passowrd')
                                        <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                                        @enderror
                                    </div>
                                    <div class="button">
                                        <button type="submit">{{ __('Change Password') }}</button>
                                    </div>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

