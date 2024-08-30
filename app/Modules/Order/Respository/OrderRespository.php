<?php namespace App\Modules\Order\Respository;

use App\Models\Setting;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\UserPayment;
use App\Models\UserAddress;

use App\Support\Traits\{
    UploadableTrait,
    StorageableTrait
};

use Stripe;

use \Carbon\Carbon;

class OrderRespository
{
    use UploadableTrait, StorageableTrait;

    static public $storage_disk = 'orders';

    static public $FOR_ORDER_STATUS_VOID        = 'void';
    static public $FOR_ORDER_STATUS_CART        = 'cart';
    static public $FOR_ORDER_STATUS_PENDING     = 'pending';
    static public $FOR_ORDER_STATUS_PROCESSING  = 'processing';
    static public $FOR_ORDER_STATUS_ON_HOLD     = 'on-hold';
    static public $FOR_ORDER_STATUS_COMPLETED   = 'completed';
    static public $FOR_ORDER_STATUS_CANCELLED   = 'cancelled';
    static public $FOR_ORDER_STATUS_REFUND      = 'refunded';
    static public $FOR_ORDER_STATUS_SHIPPING    = 'shipped';
    static public $FOR_ORDER_STATUS_DELIVERY    = 'delivered';

    static public $FOR_ORDER_TYPE_CASH_ON_DELIVER   = 'cash_on_delivery';
    static public $FOR_ORDER_TYPE_BANK_TRANSFER     = 'bank_transfer';
    static public $FOR_ORDER_TYPE_PAY_BY_PAYPAL     = 'pay_by_paypal';
    static public $FOR_ORDER_TYPE_PAY_BY_STRIPE     = 'pay_by_stripe';

    private $model = null;

    public function __construct(Order $order)
    {
        $this->model = $order;

        $this->repo_user = new \App\Modules\User\Respository\UserRespository( new User);
    }

    /*
     * API - Create New Order Generate (Database Cart)
     *
     * @param Request $request
     * @param Order $order
     */
    public function apiCartCreateOrder( $item )
    {
        $user = \Auth::user();

        $total_amount = \ShoppingCart::getCartTotal();
        $total_amount = ($total_amount + $item['price']);

        $order = Order::updateOrCreate( [ 'user_id' => $user->id, 'for_order_status' => self::$FOR_ORDER_STATUS_CART ], [
            'total_amount'   => $total_amount,
            'for_order_type' => self::$FOR_ORDER_TYPE_CASH_ON_DELIVER,
            'hospital_id'    => $user->detail->hospital_id,
        ] );


        OrderDetail::insert([
            'order_id'   => $order->id,
            'product_id' => $item['product_id'],
            'cost_price' => $item['price'],
            'qty'        => $item['qty']
        ]);

        return $order;
    }

    /*
     * API - Create New Order Generate
     *
     * @param Request $request
     * @param Order $order
     */
    public function apiCreateOrder( $postdata, Order $order )
    {
        $user = \Auth::user();
        $extras = [];

        $billing_address  = $postdata->billing;
        $shipping_address = $postdata->shipping??null;

        //For Billing
        /*$billing = array_merge( $billing_address, [ 'user_id' => $user->id ] );
        $billing = $this->repo_user->forBillingShippingCreateOrUpdate( $billing, UserAddress::$FOR_BILLING );
        $extras  = array_merge( $extras, [ 'billing_id' => $billing->id ] );*/

        //For Payment Integration
        $for_order_type = $postdata->payment_method['method'];
        $expire_package = null;
        $transactions   = null;

        switch ( $for_order_type )
        {
            //case self::$FOR_ORDER_TYPE_PAY_BY_PAYPAL:
            case self::$FOR_ORDER_TYPE_PAY_BY_STRIPE:

                $payment_info    = $postdata->payment_method[ $for_order_type ];
                $success_payment = $this->_paymentPayByGatways( $for_order_type, $payment_info );

                //Payment Errors
                if ( isset( $success_payment['payment_error'] ) && $success_payment['payment_error'] ) {
                    return ['payment_error' =>  $success_payment['payment_error']];
                }

                $extras = array_merge( $extras, [
                    'payment_info' => $success_payment,
                    'stripe_next_invoice_amount' => 0,

                ]);

                $transactions       = $success_payment[$for_order_type]['subs_trans'];
                $for_order_status   = self::$FOR_ORDER_STATUS_DELIVERY;
                $expire_package     = $success_payment[$for_order_type]['period_end'];


                $invoice_id = $transactions['latest_invoice'];
                $invoice_info = getStripeInvoiceInfoById($invoice_id);

                //Payment Errors
                if ( isset( $invoice_info['payment_error'] ) && $invoice_info['payment_error'] ) {
                    return ['payment_error' =>  $invoice_info['payment_error']];
                }
                // divided /100 is because amount returned from stripe is in *cents*, that is why
                // when we make payments we multiple * 100 and divided / 100 for acutal transation value
                $extras['stripe_next_invoice_amount'] = $invoice_info->total / 100;

            break;
            default:
                $for_order_status = self::$FOR_ORDER_STATUS_PENDING;
            break;
        }

        $order = $user->user_cart_orders;

        $order->user_id              = $user->id;
        $order->total_amount         = \ShoppingCart::getCartTotal();
        $order->for_order_type       = $for_order_type;
        $order->for_order_status     = $for_order_status;
        $order->expire_package       = $expire_package;
        $order->invoice_id           = $transactions['latest_invoice'];
        $order->subscription_id      = $transactions['id'];
        $order->current_period_start = Carbon::parse($transactions['current_period_start'])->format('Y-m-d H:i:s');
        $order->current_period_end   = Carbon::parse($transactions['current_period_end'])->format('Y-m-d H:i:s');
        $order->extras               =  $extras;
        $order->save();

        return $order;
    }

    protected function _paymentPayByGatways( $payment_type, $payment_info )
    {
        $user = \Auth::user();
        $invoice_number = rand(99,99) . $user->id;

        $total_amount = \ShoppingCart::getCartTotal();
        $description  = 'We\'ve successfully processed your payment ' . format_currency($total_amount);

        $card_info = array(
            "card" => array(
                "number"    => $payment_info['card_number'],
                "exp_month" => $payment_info['card_month'],
                "exp_year"  => $payment_info['card_year'],
                "cvc"       => $payment_info['card_cvv']
            )
        );

        try {

            $stripe_info = getStripeInitialize();

            if( isset($stripe_info['payment_error']) ) {
                return $stripe_info;
            }

            $stripe_response = \Stripe\Token::create( $card_info );
            $stripe_token_id = $stripe_response['id'] ?? null;

            //Error!! Stripe Client & Secrets information invalid
            if ( !$stripe_token_id ) {
                return [
                    'payment_error' => 'Stripe token expire, Please referesh your page'
                ];
            }

            $customer = getStripeCustomerBy($user->email, 'email');

            if( !$customer )
            {
                try {

                    $customer = \Stripe\Customer::create( array(
                        'name'   => $user->full_name,
                        'email'  => $user->email,
                        'source' => $stripe_token_id
                    ));

                    $user->stripe_customer_id = $customer->id;
                    $user->save();
                }
                catch( \Exception $e ) {
                    return [
                        'payment_error' => 'customer information something went to wrong.'
                    ];
                }
            }

            $stripe_client  = getStripeClient();
            if( !$stripe_client instanceof Stripe\StripeClient ) {
                return $stripe_client;
            }

            $item       = \ShoppingCart::getContent()->first()->product;
            $exist_subs = get_current_subscription();

            if( $exist_subs )
            {
                $order_id       = $exist_subs->id;
                $stripe_subs_id = $exist_subs->transaction_detail['id'];
                $retrieve_subsc = $stripe_client->subscriptions->retrieve($stripe_subs_id);

                if(!empty($retrieve_subsc))
                {
                    $pay_stripe = $stripe_client->subscriptions->update( $stripe_subs_id, [
                        'proration_behavior' => 'always_invoice',
                        'metadata' => [ 'invoice_number' => $exist_subs->transaction_detail['metadata']['invoice_number'] ],
                        'items'    => [[
                                 'id'    => current( $exist_subs->transaction_detail['items']['data'] )['id'],
                                 'price' => $item->stripe_product_price_id,
                             ]
                        ],
                    ]);

                    //Expire Package
                    Order::whereId($order_id)->update(['expire_package' => date('Y-m-d H:i:s'), 'for_order_status' => self::$FOR_ORDER_STATUS_VOID]);

                } else {
                    return [
                        'payment_error' => 'subscription not found.'
                    ];
                }
            }
            else
            {
                //dd('new subscriptions');
                $pay_stripe = $stripe_client->subscriptions->create([
                    'customer'           => $user->stripe_customer_id,
                    'proration_behavior' => 'always_invoice',
                    'items'              => [
                        [ 'price' => $item->stripe_product_price_id ],
                    ],
                    'metadata'           => [
                        'invoice_number' => $invoice_number
                    ],
                ]);
            }

            $pay_stripe = $pay_stripe->jsonSerialize();

            if ( $pay_stripe['status'] == 'active' )
            {
                return [
                    $payment_type => [
                        'card_holder'    => $payment_info['card_name'] ?? null,
                        'card_number'    => $payment_info['card_number'],
                        'subs_trans'     => $pay_stripe,
                        'invoice_number' => $invoice_number,
                        'customer_id'    => $pay_stripe['customer'],
                        'period_start'   => date( "Y-m-d H:i:s", $pay_stripe['current_period_start'] ),
                        'period_end'     => date( "Y-m-d H:i:s", $pay_stripe['current_period_end'] ),
                    ]
                ];
            }
            else
            {
                return [
                    'payment_error' => 'something went to wrong.'
                ];
            }
        }
        catch( \Exception $e )
        {
            return [
                'payment_error' => $e->getMessage()
            ];
        }
    }
}
