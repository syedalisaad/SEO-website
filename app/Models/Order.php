<?php namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use \App\Models\Setting;

use \App\Modules\Order\Respository\OrderRespository;

class Order extends Model
{
    use SoftDeletes;

    protected $table = 'orders';

    static $app_screen = [
        'FOR_DETAIL' => 'order_detail'
    ];

    public static function boot() {
        parent::boot();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'coupon_amount', 'shipping_amount', 'total_amount', 'order_note', 'extras', 'for_order_type', 'for_order_status','hospital_id'
    ];


    /**
    * The attributes that should be cast.
    *
    * @var array
    */
    protected $casts = [
        'extras'               => 'array',
        'current_period_start' => 'date:Y-m-d h:i:s',
        'current_period_end'   => 'date:Y-m-d h:i:s',
        'created_at'           => 'date:Y-m-d h:i:s',
        'updated_at'           => 'date:Y-m-d h:i:s',
    ];

    public function scopeIsCashOnDelivery( $q )
    {
       return $q->where('for_order_type', OrderRespository::$FOR_ORDER_TYPE_CASH_ON_DELIVER);
    }

    public function scopeIsCart( $q ) {
        return $q->where( 'for_order_status', OrderRespository::$FOR_ORDER_STATUS_CART );
    }

    public function scopeIsPending( $q ) {
        return $q->where( 'for_order_status', OrderRespository::$FOR_ORDER_STATUS_PENDING );
    }

    public function getExtraDetailAttribute() {
        return $this->extras ?? null;
    }



        public function scopeOnboardOrders( $q )
    {
        return $q->whereIn( 'orders.for_order_status', [
            OrderRespository::$FOR_ORDER_STATUS_PENDING,
            OrderRespository::$FOR_ORDER_STATUS_PROCESSING,
            OrderRespository::$FOR_ORDER_STATUS_ON_HOLD,
            OrderRespository::$FOR_ORDER_STATUS_COMPLETED,
            OrderRespository::$FOR_ORDER_STATUS_CANCELLED,
            OrderRespository::$FOR_ORDER_STATUS_SHIPPING
        ]);
    }

    public function scopeRefundOrders( $q ) {
        return $q->where( 'orders.for_order_status', OrderRespository::$FOR_ORDER_STATUS_REFUND );
    }

    public function scopeDeliveredOrders( $q ) {
        return $q->where( 'orders.for_order_status', OrderRespository::$FOR_ORDER_STATUS_DELIVERY );
    }

    public function getOrderDateAttribute() {
        return $this->created_at->format( 'F d, Y H:i A' );
    }

    public function getBankTransferAttribute() {
        return $this->extras['bank_transfer'] ?? null;
    }

    public function getBankTransferSlipDownloadAttribute()
    {
        $slip = $this->bank_transfer['slip']??null;

        if( $slip )
        {
            $storage = media_storage_url( OrderRespository::$storage_disk . '/' . $slip, null, null, '' );

            return $storage ?: default_media_url();
        }

        return $slip;
    }

    public function getOrderTotalAmountAttribute()
    {
        return $this->total_amount . ' '.Setting::$DEFAULT_CURRENCY;
    }

    public function getOrderShippmentAmountAttribute()
    {
        return $this->shipping_amount . ' '.Setting::$DEFAULT_CURRENCY;
    }

    public function getOrderStatusAttribute()
    {
        switch ( $this->for_order_status )
        {
            case OrderRespository::$FOR_ORDER_STATUS_ON_HOLD:
                return 'On Hold';
            break;

            default:
                return ucfirst($this->for_order_status);
            break;
        }
    }

    public function getOrderPaymentAttribute()
    {
        switch ( $this->for_order_type )
        {
            case OrderRespository::$FOR_ORDER_TYPE_CASH_ON_DELIVER:
                return 'Cash On Delivery';
            break;

            case OrderRespository::$FOR_ORDER_TYPE_BANK_TRANSFER:
                return 'Bank Transfer';
            break;

            case OrderRespository::$FOR_ORDER_TYPE_PAY_BY_PAYPAL:
                return 'Paypal';
            break;

            case OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE:
                return 'Stripe';
            break;

            default:
                return $this->for_order_type;
            break;
        }
    }

    public function getCustomerOrderActionAttribute()
    {
        $action = '';

        switch ( $this->for_order_status ) {
            case OrderRespository::$FOR_ORDER_STATUS_PENDING:
                $action .= '<a href="'.route(front_route('myaccount.order.action'), [$this->id, OrderRespository::$FOR_ORDER_STATUS_PENDING,OrderRespository::$FOR_ORDER_STATUS_CANCELLED]).'">Cancelled</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_DELIVERY:
                $action .= '<a href="'.route(front_route('myaccount.order.action'), [$this->id, OrderRespository::$FOR_ORDER_STATUS_DELIVERY,OrderRespository::$FOR_ORDER_STATUS_REFUND]).'">Refund</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_ON_HOLD:
                $action .= '<a href="'.route(front_route('myaccount.order.action'), [$this->id, OrderRespository::$FOR_ORDER_STATUS_ON_HOLD,OrderRespository::$FOR_ORDER_STATUS_PROCESSING]).'"><span>Processed</span></a>';
            break;
        }

        return $action;
    }

    public function getCustomerOrderTagAttribute()
    {
        $tag = '';

        switch ( $this->for_order_status )
        {
            case OrderRespository::$FOR_ORDER_STATUS_PENDING:
                $tag .= '<span class="badge bg-warning">PENDING</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_PROCESSING:
                $tag .= '<span class="badge bg-primary">PROCESSING</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_ON_HOLD:
                $tag .= '<span class="badge bg-light">ON HOLD</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_COMPLETED:
                $tag .= '<span class="badge bg-success">COMPLETED</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_CANCELLED:
                $tag .= '<span class="badge bg-danger">CANCELLED</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_REFUND:
                $tag .= '<span class="badge bg-info">REFUND</a>';
            break;
            case OrderRespository::$FOR_ORDER_STATUS_SHIPPING:
                $tag .= '<span class="badge bg-dark">SHIPPING</a>';
            break;
            default:
                $tag .= '<span class="badge bg-success">DELIVERED</a>';
            break;
        }

        return $tag;
    }

    public function getOrderItemsDetailAttribute()
    {
        $itemHTML = '';

        if( $this->hasOrderItems->count() )
        {
            foreach( $this->hasOrderItems as $item )
            {
                $itemHTML .= 'Name: ' . $item->product->name;
                $itemHTML .= '<br /> Price: ' . $item->item_price;
                //$itemHTML .= '<br /> Qty: ' . $item->qty;
                $itemHTML .= '<br /><br />';
            }
        }

        return $itemHTML;
    }

    public function getOrderSubTotalAttribute()
    {
        $total = $this->hasOrderItems->map(function($v){

            $item_amount = ($v->cost_price*$v->qty);

            if( $v->variations && count($v->variations) )
            {
                foreach ( $v->variations as $variation ) {
                    $item_amount += ($variation['price']*$variation['qty']);
                }
            }

            return $item_amount;

        })->sum();

        return format_currency($total);
    }

    public function getOrderBillingAttribute()
    {
        $billing = $this->extras['billing_id'] ?? null;

        if( $billing ) {
            return \App\Models\UserAddress::whereId($billing)->first();
        }

        return null;
    }

    public function getOrderShippingAttribute()
    {
        $shipping = $this->extras['shipping_id'] ?? null;

        if( $shipping ) {
            return \App\Models\UserAddress::whereId($shipping)->first();
        }

        return null;
    }

    public function getTransactionDetailAttribute()
    {
        return $this->extras['payment_info'][OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE]['subs_trans'] ?? $this->extras['payment_info'][OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE] ?? [];
    }

    public function getStripePaymentAttribute()
    {
        return $this->extras['payment_info'][OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE] ?? [];
    }

    public function getSubsExpireDateAttribute()
    {
        return $this->stripe_payment['period_end'] ?? null;
    }

    public function user() {
        return $this->belongsTo( User::class, 'user_id', 'id' );
    }

    public function hasOrderItems() {
        return $this->hasMany( OrderDetail::class, 'order_id', 'id' );
    }

    public function hasOneOrderItem() {
        return $this->hasOne( OrderDetail::class, 'order_id', 'id' );
    }

    public function order_items() {
        return $this->hasMany( OrderDetail::class, 'order_id', 'id' );
    }

}
