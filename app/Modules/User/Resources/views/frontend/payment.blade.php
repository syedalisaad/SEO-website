@extends( front_layout('master') )
@section('title', 'Checkout Payment')
@section('content')

    @php
        use App\Modules\Order\Respository\OrderRespository;
        $stripe_method = OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE;
    @endphp

    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }

    </style>
    <div class="dashboard">

        <div class="dash-side">
            @include( frontend_module_view('partials.sidebar') )
        </div>

        <div class="dash-data">

            <div class="dash-detial">

                @include( admin_module_view('partials.simple-messages') )

                <div class="row">
                    <div class="col-md-12">
                        <div class="page-title">Payment</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="paybox">
                            <div class="headingbox">
                                <h4>Payment Method</h4>
                            </div>
                            <div class="card-method">
                                <form action="{{ route(front_route('cart.checkout')) }}" method="POST">
                                    <div class="credit">
                                        <input type="radio" name="payment_method[method]" style="display: none" checked value="{{ OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE }}"> Stripe Payment
                                        <img src="{{ asset(front_asset('images/payment.png')) }}">
                                    </div>

                                    <div class="card-holder">
                                        <input type="text" class="@error('payment_method.'.$stripe_method.'.card_name') is-invalid @enderror" value="{{ old('payment_method.'.$stripe_method.'.card_name') }}" name="payment_method[{{ $stripe_method }}][card_name]" placeholder="Name of the card holder " maxlength="50">
                                        @error('payment_method.'.$stripe_method.'.card_name')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                    </div>
                                    <div class="card-field">
                                        <div class="card-number">
                                            <input type="number"   name="payment_method[{{ $stripe_method }}][card_number]" value="{{ old('payment_method.'.$stripe_method.'.card_number') }}" placeholder="Card Number" class="@error('payment_method.'.$stripe_method.'.card_number') is-invalid @enderror">
                                            @error('payment_method.'.$stripe_method.'.card_number')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="card-month">
                                            <input type="number" maxlength="2" name="payment_method[{{ $stripe_method }}][card_month]" value="{{ old('payment_method.'.$stripe_method.'.card_month') }}" placeholder="Month" class="@error('payment_method.'.$stripe_method.'.card_month') is-invalid @enderror">
                                            @error('payment_method.'.$stripe_method.'.card_month')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="card-month">
                                            <input type="number" maxlength="2" name="payment_method[{{ $stripe_method }}][card_year]" value="{{ old('payment_method.'.$stripe_method.'.card_year') }}" placeholder="Year" class="@error('payment_method.'.$stripe_method.'.card_year') is-invalid @enderror">
                                            @error('payment_method.'.$stripe_method.'.card_year')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                        <div class="card-month">
                                            <input type="number" maxlength="4" name="payment_method[{{ $stripe_method }}][card_cvv]" value="{{ old('payment_method.'.$stripe_method.'.card_cvv') }}" placeholder="CVV" class="@error('payment_method.'.$stripe_method.'.card_cvv') is-invalid @enderror">
                                            @error('payment_method.'.$stripe_method.'.card_cvv')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                                        </div>
                                    </div>
                                    <p>
                                        <input type="checkbox" name="i_agree" value="1" id="i_AGREE">
                                        <label for="i_AGREE">By clicking the button, You agree to the
                                            <a href="{{route(front_route('user.terms'))}}" target="_blank">Terms and Conditions</a>
                                        </label>
                                        @error('i_agree')<span class="error invalid-feedback" style="display: block">{{ $message }}</span>@enderror
                                    </p>
                                    <div class="button">
                                        <input type="submit" name="submit" value="Check Out">
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 paycontainer">
                        <div class="paybox">
                            <div class="headingbox">
                                <h4>Cart Summary</h4>
                            </div>
                            <div class="cart-summary">
                                @php $shopping_cart = \ShoppingCart::getContent(); @endphp
                                <table>
                                    @if( count($shopping_cart) )
                                        @foreach($shopping_cart as $item )
                                            @php $item_package = $item->product; @endphp
                                            <tr>
                                                <td>{{ $item->qty }} x {{ $item_package->name }}</td>
                                                <td>{{ $item->item_price }}</td>
                                                <td>
                                                    <a class="cart-close" href="{{ route(front_route('cart.delete_item'), $item_package->id) }}"><i class="fas fa-times"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    {{--<tr>
                                        <td>Tax</td>
                                        <td>{{ format_currency(0) }}</td>
                                    </tr>--}}
                                    <tr>
                                        <td>Total Price</td>
                                        <td>{{ format_currency(\ShoppingCart::getCartTotal()) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('scripts')
    <script>
        $(document).on('keypress', 'input[type="number"]', function(event){
            if(event.which != 8 && isNaN(String.fromCharCode(event.which))){
                event.preventDefault(); //stop character from entering input
            }
        });
    </script>
@endpush
