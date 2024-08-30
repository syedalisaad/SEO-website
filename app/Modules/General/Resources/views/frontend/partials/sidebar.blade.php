<ul>
    <li>
        <a href="{{ route(front_route('user.dashboard')) }}" class="{{'front.user.dashboard' == Route::currentRouteName()?'active':''}}"><i class="fas fa-home"></i> <span>Dashboard</span></a>
    </li>
    @if( \ShoppingCart::getContent()->count() )
    <li>
        <a href="{{ route(front_route('user.payment')) }}" class="{{'front.user.payment' == Route::currentRouteName()?'active':''}}"><i class="fas fa-dollar-sign"></i> <span>Payment</span></a>
    </li>
    @endif
    <li>
        <a href="{{ route(front_route('user.packages')) }}" class="{{'front.user.packages' == Route::currentRouteName()?'active':''}}"><i class="fas fa-cube"></i> <span>Packages</span></a>
    </li>
    <li>
        <a href="{{ route(front_route('user.change_password')) }}" class="{{'front.user.change_password' == Route::currentRouteName()?'active':''}}"><i class="fas fa-unlock-alt"></i> <span>Change Password</span></a>
    </li>
    <li>
        <a href="{{ route(front_route('user.edit.setting')) }}" class="{{ front_route('user.edit.setting') == Route::currentRouteName()?'active':''}}"><i class="fas fa-cog"></i> <span>Settings</span></a>
    </li>
    <li>
        <a class="gdbd_help_swal"><i class="fa fa-support"></i> <span>Help</span></a>
    </li>
    <li>
        <a href="{{ route(front_route('user.logout')) }}"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
    </li>

</ul>

<div class="help-box">
    <div class="img">
        <img src="{{asset(front_asset('images/megaphone.png'))}}" />
    </div>
    <p>Want someone to walk you through step by step?  We make it easy.</p>
    <a class="gdbd_help_swal" style="cursor: pointer">Click Here </a>
    <a class="ipad-help">
        <img src="{{asset(front_asset('images/megaphone.png'))}}" />
    </a>
</div>


<div class="modal fade" id="email-help-form-modal" tabindex="-1" role="dialog" aria-labelledby="emailHelpTemplate" aria-hidden="true">
    <div class="modal-dialog" role="document">

        <div id="email-help-form-div">
            <form class="sp-form email-help-form" id="email-help-form-modal" method="post" action="#">
                @csrf
                <input type="hidden" name="name" class="form-control " value="{{auth()->user()->first_name.' '.auth()->user()->last_name}}">
                <input type="hidden" class="form-control" name="email" value="{{ Auth::user()->email ?: '' }}"/>
                <input type="hidden" class="form-control" name="phone" value="{{ Auth::user()->phone ?: '' }}"/>
                <input type="hidden" class="form-control" name="hospital_name" value="{{ Auth::user()->detail->hospital->facility_name ?: '' }}"/>

                <div class="form-group">
                    <label class="subject-lable">Subject</label>
                    <input  class="form-control " name="subject" placeholder="Subject" value="{{ old('subject') ?: '' }}" autofocus/>
                    <div class="error_red subject_error" style="display: block"></div>
                </div>
                <div class="form-group">
                    <label class="message_lable">Message</label>
                    <textarea cols="50" style="padding-bottom: 140px!important;"  class="form-control" name="message">{{ old('message') ?: '' }}</textarea>
                    <div class="error_red message_error" style="display: block"></div>
                    <textarea cols="50" class="form-control" hidden name="hidden">{{ old('message') ?: '' }}</textarea>

                </div>
            </form>
        </div>

    </div>
</div>

<style>
    .modal-dialog {

        pointer-events: inherit!important;
    }
</style>
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">

    var swalpopup = false;
    // exampleModal
    $('.gdbd_help_swal').on('click', function () {

        swal.fire({
            title: "Contact Us",
            html: $('#email-help-form-modal').html(),
            showCancelButton: true,
            confirmButtonText: 'Send Email',
            showLoaderOnConfirm: true,
            closeOnConfirm: false,
            closeOnCancel: false,
            buttons: false,
            preConfirm: (login) => {
                var route = '{{route(front_route('user.helpemail'))}}';

                var payload = $('#email-help-form-div form').serialize();
                var data = new FormData();
                data.append("json", JSON.stringify(payload));
                return fetch(route, {
                    method: 'POST',
                    headers: {'Content-Type': 'application/x-www-form-urlencoded','X-Requested-With': 'XMLHttpRequest'},
                    body: data
                })
                    .then(response => {
                        // response = response.clone().json();
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }

                        var responsejs = response.json()
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }

                        responsejs.then(
                            function (value) {

                                console.log(value);


                                if (value.error) {
                                    console.log(value.error);
                                    console.log(value.error)
                                    swal.showValidationMessage(
                                        "Request failed:"
                                    )

                                    if (value.error.subject) {

                                        $('.subject_error').prop('display', true)
                                        $('.subject_error').html(value.error.subject);
                                    }
                                    if (value.error.message) {

                                        $('.message_error').prop('display', true)
                                        $('.message_error').html(value.error.message);
                                    }



                                }
                                console.log(value.status);
                                if (value.status == false) {

                                    // return response.json(); //then consume it again, the error happens

                                    return return_error()
                                } else {
                                    swal.close();
                                    swal.fire("Successfully Submitted!", "Thank you! we will get back to you soon.", "success");
                                }
                            }
                        )
                        //
                        console.log(response);

                        function return_error() {
                            if (response.ok) {
                                // console.log(response.json()); //first consume it in console.log
                                return response.json(); //then consume it again, the error happens
                            }
                        }

                        if (response.ok) {
                            return false; //then consume it again, the error happens
                        }
                    })
                    .catch(error => {
                        swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
            },
            allowOutsideClick: () => !swal.isLoading()
        })
    })

</script>


    @endpush
