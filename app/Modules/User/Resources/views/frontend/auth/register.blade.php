@extends( front_layout('master') )
@section('title', 'Registration')
@section('content')

    <div class="verify">
        <div class="custom-container">
            <div class="row">
                <div class="col-md-10">
                    <div class="vpack">
                        <div class="box">
                            <div class="heading">
                                <h2>Premium</h2>
                                <h6>Truly Enhance your listings</h6>
                            </div>
                            <div class="content">
                                <ul>
                                    <li>Facility Logo for Homepage & System Page</li>
                                    <li>Facility Homepage Link Added</li>
                                    <li>Quality Picture Added</li>
                                    <li>Guaranteed locked in pricing</li>
                                </ul>
                            </div>
                        </div>
                        <div class="box">
                            <div class="heading">
                                <h2>Premium Plus</h2>
                                <h6>Improve SEO with video</h6>
                            </div>
                            <div class="content">
                                <h5>All Standard Features Plus</h5>
                                <ul>
                                    <li>Add Video(s) On your Homepage</li>
                                    <li>Removal of Google Ad Space</li>
                                    <li>Embedded Link to your Homepage</li>
                                    <li>Guaranteed locked in Pricing</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <h4>Please verify your email address to proceed</h4>
                    <form action="{{route(front_route('user.register'))}}" method="POST">

                        @csrf
                        @method('post')
                        <div class="field threefield">

                            <input type="text" placeholder="First Name" class=" @error('first_name') is-invalid @enderror" name="first_name"  value="{{ old('first_name') ?? $exists_session['first_name'] ?? '' }}"/>
                            @error('first_name')
                            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="field threefield">

                            <input type="text" placeholder="Last Name" class=" @error('last_name') is-invalid @enderror" name="last_name"  value="{{ old('last_name') ?? $exists_session['last_name'] ?? '' }}"/>
                            @error('last_name')
                            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="field threefield">

                            <input type="email" placeholder="Email Address" class=" @error('email') is-invalid @enderror" name="email"  value="{{ old('email') ?? $exists_session['email'] ?? '' }}"/>
                            @error('email')
                            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="field twofield">
                            <input type="tel" minlength="10" maxlength="10" id="phone" name="phone" placeholder="000-000-0000" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone')??$exists_session['phone']??'' }}"/>
                            @error('phone')
                            <span class="error invalid-feedback" style="display: block"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="field twofield">
                            <select class="register_hospital_name @error('hospital_id') is-invalid @enderror"  name="hospital_id">
                            </select>
                            @error('hospital_id')
                            <span class="error invalid-feedback"><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <div class="button">
                            <button type="submit" value="Verify">Verify</button>
                        </div>
                        <div class="button">
                            <p><a href="{{ route(front_route('user.login')) }}" class="btn">Already registered member?</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection
@push('scripts')
    <script>
        $('#phone').on('change', function () {
            var phoneNumberString = $(this).val();
            phoneNumberString = formatPhoneNumber(phoneNumberString);
            $(this).val(phoneNumberString);


        });


    </script>
@endpush
