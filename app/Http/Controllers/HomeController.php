<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Page;
use App\Models\StripeProductPrice;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Modules\Order\Respository\OrderRespository;

use \Carbon\Carbon;
use Stripe\Product;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index( Request $request )
    {
        $posts        = Post::latest()->where( 'type_of', 'blog' )->isActive()->take( 3 )->get();
        $seo_metadata = $data->seo_metadata ?? [];

        return view( front_view( 'home' ),compact('posts') );
    }

    public function stripe_webhook( Request $request )
    {
        $stripe_info = getStripeConfig();

        if( !(isset($stripe_info['client_webhook']) && $stripe_info['client_webhook']) ) {
            return [
                'payment_error' => 'You can generate API keys from the Stripe web interface'
            ];
        }

        getStripeInitialize();

        // This is your Stripe CLI webhook secret for testing your endpoint locally.
        $endpoint_secret = $stripe_info['client_webhook'] ?: env( 'STRIPE_WEBHOOK_END_POINT' );
        $sig_header      = $_SERVER['HTTP_STRIPE_SIGNATURE'] ?: null;

        if( !$endpoint_secret ) {
            return response()->json( [
                'status'  => true,
                'message' => 'Stripe Webhook End Point Missing'
            ]);
        }

        // retrieve the request's body and parse it as JSON
        $payload = @file_get_contents( 'php://input' );
        $event   = (object) json_decode( $payload  );

        \Log::info( json_decode( $payload , true ) );

        /*try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
            print_r($event);die();
        }
        catch( \UnexpectedValueException $e ) {
            http_response_code( 400 ); // Invalid payload
            exit();
        }
        catch( \Stripe\Exception\SignatureVerificationException $e ) {
            http_response_code( 401 ); // Invalid signature
            exit();
        }*/

        // Handle the event
        switch ( $event->type )
        {
            case 'invoice.upcoming':
            case 'payment_intent.canceled':         //Occurs when a PaymentIntent is canceled.
            case 'payment_intent.created':          //Occurs when a new PaymentIntent is created.
            case 'payment_intent.payment_failed':   //Occurs when a PaymentIntent has failed the attempt to create a payment method or a payment.
            case 'payment_intent.processing':       //Occurs when a PaymentIntent has started processing.
            case 'payment_intent.requires_action':  //Occurs when a PaymentIntent transitions to requires_action state
            case 'payment_intent.succeeded':        //Occurs when a PaymentIntent has successfully completed payment.
            break;
            case 'subscription_schedule.aborted':  //Occurs whenever a subscription schedule is canceled due to the underlying subscription being canceled because of delinquency.
            case 'subscription_schedule.canceled': //Occurs whenever a subscription schedule is canceled.

                $response = $event->data->object;
                $customer = $response->customer;

                $user = User::where('stripe_customer_id', $customer)->first();
                //print_r($user);die();

                if( $user )
                {
                    Order::where('user_id', $user->id)->update([
                        'expire_package'   => date('Y-m-d H:i:s'),
                        'for_order_status' => OrderRespository::$FOR_ORDER_STATUS_CANCELLED
                    ]);
                }

            break;
            case 'subscription_schedule.completed':  //Occurs whenever a new subscription schedule is completed.

            break;
            case 'subscription_schedule.created':   //Occurs whenever a new subscription schedule is created.
            case 'subscription_schedule.released': //Occurs whenever a new subscription schedule is released.

                $response     = $event->data->object;
                $customer     = $response->customer;
                //$customer     = 'cus_Kdy34pJZXSeoea';

                $user = User::where('stripe_customer_id', $customer)->first();

                if( $user )
                {
                    $hospital_id = $user->detail->hospital_id;
                    $order       = $user->user_order;

                    if( $order ) {
                        Order::whereId($order->id)->update(['expire_package' => Carbon::now()->format('Y-m-d H:i:s'), 'for_order_status' => OrderRespository::$FOR_ORDER_STATUS_VOID]);
                    }

                    $subscription = $response->subscription;
                    //$subscription = 'sub_1JyzbIJRU6R71bcgnqyhBTDm';
                    $subscription = getStripeSubscriptionById( $subscription );
                    $subscription = $subscription->jsonSerialize();
                    $plan         = $subscription['plan'];
                    $product      = StripeProductPrice::where('stripe_product_price_id', $plan['id'])->first();
                    $extras = [
                        'payment_info'               => $subscription,
                        'stripe_next_invoice_amount' => 0,
                    ];

                    $order = new Order;
                    $order->hospital_id          = $hospital_id;
                    $order->user_id              = $user->id;
                    $order->total_amount         = $plan['amount'];
                    $order->for_order_type       = OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE;
                    $order->for_order_status     = OrderRespository::$FOR_ORDER_STATUS_DELIVERY;
                    $order->expire_package       = Carbon::parse($subscription['current_period_end'])->format('Y-m-d H:i:s');
                    $order->invoice_id           = $subscription['latest_invoice'];
                    $order->subscription_id      = $subscription['id'];
                    $order->current_period_start = Carbon::parse($subscription['current_period_start'])->format('Y-m-d H:i:s');
                    $order->current_period_end   = Carbon::parse($subscription['current_period_end'])->format('Y-m-d H:i:s');
                    $order->extras               = $extras;
                    $order->save();

                    if( $product )
                    {
                        OrderDetail::insert([
                            'order_id'   => $order->id,
                            'product_id' => $product->id,
                            'cost_price' => $product->price,
                            'qty'        => 1,
                        ]);
                    }
                }

            break;
            //Occurs 7 days before a subscription schedule will expire.
            case 'subscription_schedule.expiring':

                $response     = $event->data->object;
                $customer     = $response->customer;
                //$customer     = 'cus_Kdy34pJZXSeoea';
                $subscription = $response->subscription;
                //$subscription = 'sub_1JyzbIJRU6R71bcgnqyhBTDm';
                $subscription = getStripeSubscriptionById( $subscription );
                $subscription = $subscription->jsonSerialize();
                $plan         = $subscription['plan'] ?? null;
                $product      = StripeProductPrice::where('stripe_product_price_id', $plan['id'] ?? null )->first();

                $user = User::where('stripe_customer_id', $customer)->first();

                if( $user && $product )
                {
                    $settings = get_site_settings();
                    $sites    = $settings['sites'];
                    $subject  = $sites['site_name'] . ' - It’s Time to Renew Your Subscription!';

                    try {
                        \Mail::to( $user->email )->send( new \App\Mail\FrontendMail( 'webhook.user_expire_subscription', $subject, $user,[
                            'product' => $product
                        ]));
                    }
                    catch( \Exception $e ) {
                        \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
                    }
                }

            break;
            case 'subscription_schedule.updated':
                //Don't Needed
            break;
            default:
                \Log::info($event->type, $event); //Received unknown event type
            break;
        }

        return response()->json([
            'status' => true,
            'message' => 'Successfully Updated'
        ]);
    }
}
