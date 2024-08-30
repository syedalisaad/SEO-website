@php use \App\Modules\Order\Respository\OrderRespository; @endphp
<div class="row">
    <div class="col-12 table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th><i class="fas fa-book"></i></th>
                    <th>Product</th>
                    <th width="40%">Description</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach( $order->hasOrderItems as $item )
                    @php $sub_total  = ($item->cost_price*$item->qty); @endphp
                <tr>
                    <td><i class="fas fa-book"></i></td>
                    <td>
                        {{ $item->product->name }}
                        @if( $item->variations && count($item->variations) )
                            <br /><br /><h6><strong>Variations</strong></h6>
                            @foreach( $item->variations as $variation)
                                @php $sub_total += ($variation['qty']*$variation['price']); @endphp
                                <p class="m-0">
                                    <strong>{{ $variation['variation_name'] }}</strong> {{ $variation['name'] }}
                                    ( {{ $variation['qty'] }} x {{ $variation['price'] }} )
                                </p>
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $item->product->short_desc }}</td>
                    <td>{{ $item->item_price }}</td>
                    <td>{{ format_currency($sub_total) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col-6">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>{{ $order->order_sub_total }}</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>{{ $order->order_total_amount }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-12">

            @switch( $order->for_order_type )
                @case( OrderRespository::$FOR_ORDER_TYPE_BANK_TRANSFER )
                    <p class="lead">Bank Transfer:</p>
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                        @if( $order->bank_transfer_slip_download )
                            <strong> Transfer Slip </strong> <a href="{{ $order->bank_transfer_slip_download }}" target="_blank">Download</a>
                        @endif
                    </p>
                @break
                @case( OrderRespository::$FOR_ORDER_TYPE_PAY_BY_PAYPAL )
                @case( OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE )
                    <p class="lead">Payment Methods:</p>
                    <img src="{{ admin_asset('dist/img/credit/visa.png') }}" alt="Visa">
                    <img src="{{ admin_asset('dist/img/credit/mastercard.png') }}" alt="Mastercard">
                    <img src="{{ admin_asset('dist/img/credit/american-express.png') }}" alt="American Express">
                    <img src="{{ admin_asset('dist/img/credit/paypal2.png') }}" alt="Paypal">
                    <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;"></p>
                @break
            @endswitch

        </div>
    </div>

    @switch( $order->for_order_status )
        @case( OrderRespository::$FOR_ORDER_STATUS_PROCESSING )
        @case( OrderRespository::$FOR_ORDER_STATUS_ON_HOLD )
        @case( OrderRespository::$FOR_ORDER_STATUS_PROCESSING )
        <div class="col-6">
            <form method="POST" action="{{ route(admin_route('order.revoke.submit')) }}">
                @csrf <input type="hidden" name="order_id" value="{{ $order->id }}"/>
                <div class="form-group row mt-3">
                    <div class="col-sm-6">
                        <label class="cust-label">Order Status <strong style="color:#c00">*</strong></label>
                        <select name="order_status" class="form-control form-control-sm select2 @error('order_status') is-invalid @enderror">
                            <option value="" disabled="" selected="">Select your status</option>
                            <option value="{{ OrderRespository::$FOR_ORDER_STATUS_PROCESSING }}">Processing</option>
                            <option value="{{ OrderRespository::$FOR_ORDER_STATUS_ON_HOLD }}">On-Hold</option>
                            <option value="{{ OrderRespository::$FOR_ORDER_STATUS_COMPLETED }}">Completed</option>
                            <option value="{{ OrderRespository::$FOR_ORDER_STATUS_CANCELLED }}">Cancelled</option>
                            <option value="{{ OrderRespository::$FOR_ORDER_STATUS_REFUND }}">Refunded</option>
                            <option value="{{ OrderRespository::$FOR_ORDER_STATUS_SHIPPING }}">Shipped</option>
                            <option value="{{ OrderRespository::$FOR_ORDER_STATUS_DELIVERY }}">Delivered</option>
                        </select>
                        @error('order_status')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-sm-12">
                        <label class="cust-label">Order Note</label>
                        <div class="input-group">
                            <textarea name="order_note" class="texteditor form-control @error('order_note') is-invalid @enderror" placeholder="Order Note">{{ old('order_note')?:null }}</textarea>
                            @error('order_note')<span class="error invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                    </div>
                </div>

                <div class="row form-group">
                    <div class="col-12">
                        <button type="button" onclick="window.reload();" class="btn btn-primary float-right">
                            <i class="fas fa-eraser"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success float-right mr-2"><i class="far fa-credit-card"></i> Continue Order</button>
                    </div>
                </div>

            </form>
        </div>
        @break
    @endswitch
</div>

