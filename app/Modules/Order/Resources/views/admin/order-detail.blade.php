@extends( admin_module_layout('master') )
@section('title', $title )
@section('breadcrumbs')
    <div class="col-sm-6">
        <h1>{{ $title }}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route(admin_route('dashboard')) }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route( $uriback ) }}">Orders</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
    </div>
@endsection
@section('content')

    <section class="content">
        <div class="container-fluid">

            @include( admin_module_view('partials.simple-messages') )

            <div class="row">
                <div class="col-12">

                    <div class="invoice p-3 mb-3">

                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> Order #, {{ $order->id }}.
                                    <small class="float-right">Order Date: {{ $order->created_at->format('F d, Y')}}</small>
                                </h4>
                            </div>
                        </div>
                        <div class="row invoice-info mb-5">
                            <div class="col-sm-4 invoice-col">
                                @if( $order->order_billing )
                                    Billing Information
                                    @include( admin_module_render('order-detail.addresses'), ['address' => $order->order_billing ])
                                @endif
                            </div>

                            <div class="col-sm-4 invoice-col">
                                @if( $order->order_shipping )
                                    Shipping Information
                                    @include( admin_module_render('order-detail.addresses'), ['address' => $order->order_shipping ])
                                @endif
                            </div>
                            <div class="col-sm-4 invoice-col">
                                <b>Order Information</b><br>
                                <br>
                                <b>Order No:</b> #{{ $order->id }}<br>
                                <b>Order User:</b> <span class="badge bg-info">{{ $order->user->full_name }}</span><br>
                                <b>Order Status:</b> {{ $order->order_status }}<br>
                                <b>Payment Type:</b> <span class="badge bg-info">{{ $order->order_payment }}</span><br>
                                <b>Total Amount:</b> {{ $order->order_total_amount }}<br>
                                <b>Expiry Subscription:</b> {{ \Carbon\Carbon::parse($order->subs_expire_date)->format('M d, Y h:i A') }}<br>
                                @if(  $order->transaction_detail && $order->transaction_detail['latest_invoice'] )
                                    @php $latest_invoice = getStripeInvoiceById($order->transaction_detail['latest_invoice'])  @endphp
                                    @if( !isset($latest_invoice['payment_error']) )
                                    <b>Upcoming Invoice:</b> <a href="{{ $latest_invoice }}">Download</a> <br>
                                    @endif
                                @endif
                                <b>Order Date:</b> {{ $order->created_at->format('M d, Y h:i A')}}<br>
                            </div>
                        </div>

                        @include( admin_module_render('order-detail.order-item-detail'), ['order' => $order ])

                    </div>

                </div>
            </div>

        </div>
    </section>
@endsection
