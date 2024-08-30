@extends( front_layout('master') )
@section('title', 'contact-us')
@section('content')

    <section class="contact">
        <div class="container">
            <div class="row">
                <div class="col-md-7">
                    <h2>Have a Question?<br> Let's Discuss</h2>
                    <p>Please let us know if you prefer email or a phone response, and what we can assist you with.</p>
                    <form class="contactform" id="contact-us-form" action="{{ route(front_route('page.contact') )  }}" method="POST">

{{--                        <input type="hidden" id="g-recaptcha-response" name="g-recaptcha-response">--}}
{{--                        <input type="hidden" name="action" value="validate_captcha">--}}
                        @csrf
                        <div class="half">
                            <input class="textfield @error('first_name') txt-error @enderror" type="text" name="first_name" placeholder="First Name" value="{{ old('first_name') }}">
                            @error('first_name')
                            <div class="response_msg alert-danger">{{ $message }} </div> @enderror
                        </div>
                        <div class="half">
                            <input class="textfield" type="text" name="last_name" placeholder="Last Name" value="{{ old('last_name') }}">
                            @error('last_name')
                            <div class="response_msg alert-danger">{{ $message }} </div> @enderror
                        </div>
                        <div class="half">
                            <input class="textfield" type="tel" name="phone" placeholder="Phone">
                            @error('phone')
                            <div class="response_msg alert-danger">{{ $message }} </div> @enderror
                        </div>
                        <div class="half">
                            <input class="textfield" type="email" name="email" placeholder="Email Address">
                            @error('email')
                            <div class="response_msg alert-danger">{{ $message }} </div> @enderror
                        </div>
                        <div class="full">
                            <textarea class="textfield" maxlength="250" placeholder="Your message - Max 250 characters allowed" name="message"></textarea>
                            @error('message')
                            <div class="response_msg alert-danger">{{ $message }} </div> @enderror
                        </div>

                        <div id="rss"></div>

{{--                        <div id="html_element" style="margin-bottom: 5px"></div>--}}
                        <div class="g-recaptcha" id="g-recaptcha" data-sitekey="6LcLiQQiAAAAAL2Os_fOg0jVbfzuW5arrOwGCq0c"></div>

                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                        <button type="submit" class="g-recaptcha"
                                data-sitekey="{{env('RECAPTURE_KEY')}}"
                                data-callback='onSubmit'
                                data-action='submit'>Send
                        </button>
                    </form>
                </div>
                <div class="col-md-5">
                    <div class="img">
                        <img src="{{asset(front_asset('images/contact.webp'))}}">
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
{{--    <script src='https://www.google.com/recaptcha/api.js'></script>--}}
    <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
            async defer>
    </script>

    </script>

    <script type="text/javascript">
        var onloadCallback = function () {
            grecaptcha.render('g-recaptcha', {
                'sitekey': '6LcLiQQiAAAAAL2Os_fOg0jVbfzuW5arrOwGCq0c'
            });


            // document.getElementById("contact-us-form").addEventListener("submit", function (evt) {

                //
                // var response = grecaptcha.getResponse();
                // if (response.length == 0) {
                //     //reCaptcha not verified
                //
                //
                //
                //     alert("please verify you are humann!");
                //     evt.preventDefault();
                //     $('#const-spinner').hide();
                //     return false;
                // }else if(response.length != 0){
                //     // $('#g-recaptcha-response').val(response)
                // }

                //captcha verified
                //do the rest of your validations here

            // });
        };
    </script>
    <script>


        {{--function onSubmit(token) {--}}


        {{--    // document.getElementById("contact-us-form").submit();--}}
        {{--}--}}

        {{--function onClick(e) {--}}
        {{--    e.preventDefault();--}}
        {{--    grecaptcha.ready(function() {--}}
        {{--        grecaptcha.execute('{{env('RECAPTURE_KEY')}}', {action: 'submit'}).then(function(token) {--}}
        {{--            // Add your logic to submit to your backend server here.--}}
        {{--        });--}}
        {{--    });--}}
        {{--}--}}

    </script>

@endpush
