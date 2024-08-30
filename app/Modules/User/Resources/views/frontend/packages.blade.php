@extends( front_layout('master') )
@section('title', 'Dashboard')
@section('content')

    <div class="dashboard">

        <div class="dash-side">
            @include( frontend_module_view('partials.sidebar') )
        </div>

        <div class="dash-data">
            <div class="dash-detial">
                @include( admin_module_view('partials.simple-messages') )
                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title">
                            Packages
                        </div>
                    </div>
                </div>

                @php $subscribe_order = get_current_subscription();  @endphp

                @if( $subscribe_order )
                    @php $subscribe = $subscribe_order->order_items->first()->product; @endphp
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $subscribe->name }}</h5>
                                    <p class="card-text">
                                        Billing {{ $subscribe->format_recurry }} - Next invoice on {{ carbon\carbon::parse($subscribe_order->current_period_end)->format('M d Y') }}
                                        for {{ number_format($subscribe_order->total_amount, 2) . ' '. \App\Models\Setting::$DEFAULT_CURRENCY }}
                                    </p>
                                    {{--                            <a href="{{ route(front_route('user.unsubscribe.package'), $user->user_order->id) }}" class="btn btn-primary">Unsubscribe</a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>

                @else
                    @php $subscribe_order_last = get_last_subscription();  @endphp

                    @if( $subscribe_order_last )
                        @php $subscribe_last = $subscribe_order_last->order_items->first()->product; @endphp
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Last subscription {{ $subscribe_last->name }} (expired on {{ carbon\carbon::parse($subscribe_order_last->current_period_end)->format('M d Y') }})</h5>

                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <br>
                    @endif
                @endif

                <div class="packbox">

                    <div class="csul">
                        <div class="csli">
                            @if( isset($package_details['package_premium']))
                                <form method="post" id="tier-premium-form" action="{{route(front_route('cart.add_to_cart'))}}" class="d-flex">
                                    @csrf
                                    <input type="hidden" name="total_price" value="0"/>
                                    <input type="hidden" name="selected_package_name" value="0"/>
                                    <input type="hidden" name="selected_package_tier" value="0"/>
                                    <input type="hidden" name="selected_package_addon" value="0"/>
                                    <div class="box package-premium">
                                        <div class="headingbox">
                                            <h2>Premium</h2>
                                            <h6>Truly Enhance your listings</h6>
                                        </div>
                                        <div class="detial package_details">
                                            <label class="switch">
                                                <input type="checkbox" name="tier-premium" class="checkbox_tier">
                                                <span class="slider round"></span>
                                            </label>
                                            <span class="price" data-price="0">0</span>
                                            <?php $no = 1 ?>
                                            @if( isset($package_details['package_premium']) && count($package_details['package_premium']))
                                                @foreach($package_details['package_premium'] as $k => $item)
                                                    @php
                                                        if($k == 'stripe_product_id') continue;
                                                        $add_ons = $item['add_ons'];
                                                    @endphp
                                                    <ul class="extra-features addons-{{$k}} {{ $k =='yearly' ? 'd-none' : '' }}" style="display:none;">
                                                        @foreach($add_ons as $key => $it)
                                                            <li>
                                                                <input type="radio" name="addon_video" {{$no==1 ?"checked":''}} data-name="{{ $key }}" data-recurring="{{$k}}" data-price="{{  $it['price']  }}" data-package="{{  $it['pacakge_name']  }}" value="{{  $it['stripe_product_price_id']  }}"/>
                                                                <span>{{  $it['content']  }}</span>
                                                            </li>
                                                            <?php $no = 2;?>
                                                        @endforeach
                                                    </ul>
                                                @endforeach
                                            @endif

                                            <ul class="features">
                                                <li><i class="fas fa-check"></i> Facility Logo for Homepage & System Page</li>
                                                <li><i class="fas fa-check"></i> Facility Homepage Link Added</li>
                                                <li><i class="fas fa-check"></i> Quality Picture Added</li>
                                                <li><i class="fas fa-check"></i> Guaranteed locked in pricing</li>
                                            </ul>
                                            @if( isset($package_details['package_premium']) && count($package_details['package_premium']))
                                                <div class="get-start">
                                                    <input type="submit" name="premium" class="package_selection" value="Get Started">
                                                    <p><a href="javascript:" class="system_price" {{--data-toggle="modal" data-target="#exampleModal" --}}
                                                        class="system_price">Click Here</a> For System Pricing
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            @endif
                        </div>
                        <div class="csli">
                            @if( isset($package_details['package_premium_plus']))
                        <form method="post" id="tier-premium-plus-form" action="{{route(front_route('cart.add_to_cart'))}}" class="d-flex ">
                            @csrf
                            <div class="box package-premium-plus">
                                <div class="headingbox">
                                    <h2>Premium Plus</h2>
                                    <h6>Improve SEO with video</h6>
                                </div>
                                <div class="detial package_details">
                                    <label class="switch">
                                        <input type="checkbox" name="tier-premium-plus" class="checkbox_tier">
                                        <span class="slider round"></span>
                                    </label>
                                    <span class="price" data-price="0">0</span>
                                    <h5>All Standard Features Plus <br>Add Video</h5>
                                    <?php $no = 1 ?>
                                    @if( isset($package_details['package_premium_plus']) && count($package_details['package_premium']))
                                        @foreach($package_details['package_premium_plus'] as $k => $item)
                                            @php
                                                if($k == 'stripe_product_id') continue;
                                                $add_ons = $item['add_ons'];
                                            @endphp
                                            <ul class="extra-features addons-{{$k}} {{ $k =='yearly' ? 'd-none' : '' }}">
                                                @foreach($add_ons as $key => $it)
                                                    <li>
                                                        <input type="radio" name="addon_video" {{$no==1 ?"checked":''}} data-name="{{ $key }}" data-recurring="{{$k}}" data-price="{{  $it['price']  }}" data-package="{{  $it['pacakge_name']  }}" value="{{  $it['stripe_product_price_id']  }}"/>
                                                        <span style="color: black;">{{  $it['content']  }}</span>
                                                    </li>
                                                    <?php $no = 2;?>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    @endif
                                    <ul class="features">
                                        <li><i class="fas fa-check"></i> Removal of Google Ad Space</li>
                                        <li><i class="fas fa-check"></i> Embedded Link to your Homepage</li>
                                        <li><i class="fas fa-check"></i> Guaranteed locked in Pricing</li>
                                    </ul>
                                    @if( isset($package_details['package_premium_plus']) && count($package_details['package_premium']))
                                        <div class="get-start">
                                            <input type="submit" name="premium_plus" class="package_selection" value="Get Started">
                                            <p><a href="javascript:" class="system_price" data-toggle="modal" data-target="#exampleModal">Click Here</a> For System Pricing</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    @endif
                        </div>
                        <div class="csli">
                            {{--                    test package--}}
                            @if( isset($package_details['test_products']))
                        <form method="post" id="tier-test_product-form" action="{{route(front_route('cart.add_to_cart'))}}" class="d-flex ">
                            @csrf
                            <div class="box test_product">
                                <div class="headingbox">
                                    <h2>Test Product</h2>
                                    <h6>Improve SEO with video</h6>
                                </div>
                                <div class="detial package_details">
                                    <label class="switch">
                                        <input type="checkbox" name="tier-test_product" class="checkbox_tier">
                                        <span class="slider round"></span>
                                    </label>
                                    <span class="price" data-price="0">0</span>
                                    <h5>All Standard Features Plus <br>Add Video</h5>
                                    <?php $no = 1 ?>
                                    @if( isset($package_details['test_products']) && count($package_details['test_products']))
                                        @foreach($package_details['test_products'] as $k => $item)
                                            @php
                                                if($k == 'stripe_product_id') continue;
                                                $add_ons = $item['add_ons'];
                                            @endphp
                                            <ul class="extra-features addons-{{$k}} {{ $k =='yearly' ? 'd-none' : '' }}">
                                                @foreach($add_ons as $key => $it)
                                                    <li>
                                                        <input type="radio" name="addon_video" {{$no==1 ?"checked":''}} data-name="{{ $key }}" data-recurring="{{$k}}" data-price="{{  $it['price']  }}" data-package="{{  $it['pacakge_name']  }}" value="{{  $it['stripe_product_price_id']  }}"/>
                                                        <span style="color: black;">{{  $it['content']  }}</span>
                                                    </li>
                                                    <?php $no = 2;?>
                                                @endforeach
                                            </ul>
                                        @endforeach
                                    @endif
                                    <ul class="features">
                                        <li><i class="fas fa-check"></i> Removal of Google Ad Space</li>
                                        <li><i class="fas fa-check"></i> Embedded Link to your Homepage</li>
                                        <li><i class="fas fa-check"></i> Guaranteed locked in Pricing</li>
                                    </ul>
                                    @if( isset($package_details['test_products']) && count($package_details['test_products']))
                                        <div class="get-start">
                                            <input type="submit" name="test_product" class="package_selection" value="Get Started">
                                            <p><a href="javascript:" class="system_price" data-toggle="modal" data-target="#exampleModal">Click Here</a> For System Pricing</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </form>
                    @endif
                        </div>
                    </div>

                </div>

                <div class="zandesk gdbd_help_swal_trigger">
                    <div class="icon">
                        <i class="fa fa-comment"></i>
                    </div>
                    <div class="text">
                        Want a live person to walk you through the set up?  <a class="gdbd_help_swal" style="color: white;"> Click here!</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Modal -->

    <div class="modal fade " id="system-pricing-form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">

            <div id="system-pricing-form">
                <form class="sp-form system-pricing-form" id="system-pricing-form" method="post" action="#">
                    @csrf

                    <div class="form-group">
                        <label for="name">Name*</label>
                        <input class="form-control " value="{{old('name') ? old('name') : auth()->user()->first_name.' '.auth()->user()->last_name}}" type="text" name="name">

                        <div class="error_red name_error" id="" style="display: block"></div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email*</label>
                        <input class="form-control " value="{{auth()->user()->email}}" type="email" name="email">

                        <div class="error_red email_error" id="" style="display: block"></div>
                    </div>
                    <div class="form-group">
                        <label for="pop_phone">Phone*</label>
                        <input type="tel" minlength="10" maxlength="10" id="pop_phone" name="phone" placeholder="0000000000" class="onlynumberallow form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone')?? str_replace(array(" ","-","(" ,")"),"",auth()->user()->phone)??'' }}"/>

                        <span class="error_red phone_error" id="" style="display: block"></span>
                    </div>
                    <div class="form-group">
                        <label for="desc">Description</label>
                        <textarea class="form-control" name="desc">{{old('desc')}}</textarea>
                    </div>


                </form>
            </div>

        </div>
    </div>



@endsection
@push('scripts')

    {{--    <script type="text/javascript" src="{{ asset(front_asset('js/sweetalert2.js')) }}"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript">

        var swalpopup = false;
        // exampleModal
        $('.system_price').on('click', function () {

            swal.fire({
                title: "System Pricing",
                html: $('#system-pricing-form').html(),
                showCancelButton: true,
                confirmButtonText: 'Look Up',
                showLoaderOnConfirm: true,
                closeOnConfirm: false,
                closeOnCancel: false,
                buttons: false,
                preConfirm: (login) => {
                    var route = '{{route(front_route('user.systemprice'))}}';

                    var payload = $('.swal2-modal form').serialize();
                    var data = new FormData();
                    data.append("json", JSON.stringify(payload));
                    return fetch(route, {
                        method: 'POST',
                        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
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

                                        if (value.error.name) {
                                            $('.name_error').prop('display', true)

                                            $('.name_error').html(value.error.name);
                                        }
                                        if (value.error.phone) {
                                            $('.phone_error').prop('display', true)
                                            $('.phone_error').html(value.error.phone);
                                        }
                                        if (value.error.email) {
                                            $('.email_error').prop('display', true)
                                            $('.email_error').html(value.error.email);
                                        }


                                    }
                                    console.log(value.status);
                                    if (value.status == false) {

                                        // return response.json(); //then consume it again, the error happens

                                        return return_error()
                                    } else {
                                        swal.close();
                                        swal.fire("Successfully Submitted!", "Thank you! we will get back to you as soon.", "success");
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


        package_details_json = '@php echo json_encode($package_details, true); @endphp';
        $(window).on('load', function () {
            package_details = JSON.parse(package_details_json);
            console.log(package_details);

            // this is for price onchange
            setTimeout(function () {
                $('.checkbox_tier').trigger('change');

                if ($('.addons-monthly').is(':visible')) {
                    $('.addons-monthly [name="addon_video"]:first').trigger('click');
                } else if ($('.addons-yearly').is(':visible')) {
                    $('.addons-yearly [name="addon_video"]:first').trigger('click');
                }


                $('.package_selection').on('click', function (e) {
                    var that = $(this);
                    var selected_json = that.attr('data-selected-json');
                    that.prop('disabled', true);
                    // var container_closest = that.closest('.package_details');
                    // var container_parent = that.closest('.package_details').parent();
                    // var total_price = container_closest.find('[data-price]').html();
                    // var selected_package_name = container_parent.find('h2').html();
                    // var selected_package_tier = $('.checkbox_tier').is(':checked') ? 'yearly' : 'monthly';
                    // var selected_package_addon = $('[name="addon_video"]').attr('data-name');
                    //
                    // $('[name="total_price"]').val(total_price);
                    // $('[name="selected_package_name"]').val(selected_package_name);
                    // $('[name="selected_package_tier"]').val(selected_package_tier);
                    // $('[name="selected_package_addon"]').val(selected_package_addon);

                    that.prop('disabled', false);

                    setTimeout(function () {
                        if (that.prop('disabled')) {
                            return false;
                        } else {
                            that.submit();
                        }

                    }, 90);
                });

                $('input[name="addon_video"]').on("click", function () {

                    var price = $(this).data('price');
                    console.log(price);
                    var package_details_container = $(this).closest('.package_details');
                    package_details_container.find('[data-price]').html(addCommas(price));
                });

            }, 100);
        });

        $('.checkbox_tier').on('change', function (e) {
            var checkbox_tier = $(this);
            changePricing(checkbox_tier);
        });


        function changePricing(checkbox_tier) {
            var package_details_container = $('#tier-premium-form').find('.package_details');
            var package_details_container_plus = $('#tier-premium-plus-form').find('.package_details');
            var package_details_container_test_product = $('#tier-test_product-form').find('.package_details');
            var price = 0;

            if (checkbox_tier.is(':checked') && checkbox_tier.attr('name') === 'tier-premium') {
                // yearly
                $('#tier-premium-form .addons-monthly').addClass('d-none');
                $('#tier-premium-form .addons-yearly').removeClass('d-none');
                var form_name = checkbox_tier.closest('form');
                var data_name = form_name.find('[name="addon_video"]:checked').data('name')
                $('input[name="addon_video"]').each(function (index) {
                    if ($(this).data('name') == data_name && $(this).data('recurring') == 'yearly' && $(this).data('package') == 'package_premium') {
                        $(this).prop('checked', true);
                    }
                });
                // price = package_details.package_premium.yearly.price;
                if ($('#tier-premium-form input[name="addon_video"]:checked')) {
                    price = $('#tier-premium-form input[name="addon_video"]:checked').data('price');
                }
                package_details_container.find('[data-price]').html(addCommas(price));

            } else if (!checkbox_tier.is(':checked') && checkbox_tier.attr('name') === 'tier-premium') {
                // monthly
                $('#tier-premium-form .addons-monthly').removeClass('d-none');
                $('#tier-premium-form .addons-yearly').addClass('d-none');
                var form_name = checkbox_tier.closest('form');
                var data_name = form_name.find('[name="addon_video"]:checked').data('name')
                $('input[name="addon_video"]').each(function (index) {

                    if ($(this).data('name') == data_name && $(this).data('recurring') == 'monthly' && $(this).data('package') == 'package_premium') {

                        $(this).prop('checked', true);
                    }

                });
                price = package_details.package_premium_plus.yearly.price;
                if ($('#tier-premium-form input[name="addon_video"]:checked')) {
                    price = $('#tier-premium-form input[name="addon_video"]:checked').data('price');
                }
                package_details_container.find('[data-price]').html(price);
            }


            if (checkbox_tier.is(':checked') && checkbox_tier.attr('name') === 'tier-premium-plus') {
                // yearly
                $('#tier-premium-plus-form .addons-monthly').addClass('d-none');
                $('#tier-premium-plus-form .addons-yearly').removeClass('d-none');


                var form_name = checkbox_tier.closest('form');

                var data_name = form_name.find('[name="addon_video"]:checked').data('name')
                console.log(form_name.find('[name="addon_video"]:checked').data('name'));
                $('input[name="addon_video"]').each(function (index) {

                    if ($(this).data('name') == data_name && $(this).data('recurring') == 'yearly' && $(this).data('package') == 'package_premium_plus') {

                        $(this).prop('checked', true);
                    }
                });
                if ($('#tier-premium-plus-form input[name="addon_video"]:checked')) {
                    price = $('#tier-premium-plus-form input[name="addon_video"]:checked').data('price');
                }
                package_details_container_plus.find('[data-price]').html(addCommas(price));

            } else if (!checkbox_tier.is(':checked') && checkbox_tier.attr('name') === 'tier-premium-plus') {
                // monthly
                $('#tier-premium-plus-form .addons-monthly').removeClass('d-none');
                $('#tier-premium-plus-form .addons-yearly').addClass('d-none');


                var form_name = checkbox_tier.closest('form');

                var data_name = form_name.find('[name="addon_video"]:checked').data('name')
                console.log(form_name.find('[name="addon_video"]:checked').data('name'));
                $('input[name="addon_video"]').each(function (index) {
                    if ($(this).data('name') == data_name && $(this).data('recurring') == 'monthly' && $(this).data('package') == 'package_premium_plus') {

                        $(this).prop('checked', true);
                        var price = $(this).val();
                    }
                });
                price = package_details.package_premium_plus.yearly.price;
                if ($('#tier-premium-plus-form input[name="addon_video"]:checked')) {
                    price = $('#tier-premium-plus-form input[name="addon_video"]:checked').data('price');
                }
                package_details_container_plus.find('[data-price]').html(addCommas(price));

            } else if (!checkbox_tier.is(':checked') && checkbox_tier.attr('name') === 'tier-test_product') {
                // monthly
                $('#tier-test_product-form .addons-monthly').removeClass('d-none');
                $('#tier-test_product-form .addons-yearly').addClass('d-none');


                var form_name = checkbox_tier.closest('form');

                var data_name = form_name.find('[name="addon_video"]:checked').data('name')
                console.log(form_name.find('[name="addon_video"]:checked').data('name'));
                $('input[name="addon_video"]').each(function (index) {
                    if ($(this).data('name') == data_name && $(this).data('recurring') == 'monthly' && $(this).data('package') == 'package_premium_plus') {

                        $(this).prop('checked', true);
                        var price = $(this).val();
                    }
                });
                price = package_details.test_products.yearly.price;

                if ($('#tier-test_product-form input[name="addon_video"]:checked')) {
                    price = $('#tier-test_product-form input[name="addon_video"]:checked').data('price');
                }
                package_details_container_test_product.find('[data-price]').html(addCommas(price));

            }


        }


        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }

        $(document).on('change', '#pop_phone', function () {
            var phoneNumberString = $(this).val();
            phoneNumberString = formatPhoneNumber(phoneNumberString);
            $(this).val(phoneNumberString);
        });

        $(".zandesk").click(function(){
            $(".zandesk").toggleClass("active");
            if($('.gdbd_help_swal_trigger').length>0){
                $(this).removeClass("gdbd_help_swal_trigger");
                setTimeout(function () {
                    $('.gdbd_help_swal').click();
                }, 1000);
            }

        });




    </script>





@endpush
