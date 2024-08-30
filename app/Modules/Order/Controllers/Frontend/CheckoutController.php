<?php namespace App\Modules\Order\Controllers\Frontend;

use App\Models\Setting;
use App\Modules\Order\Respository\OrderRespository;
use Illuminate\Http\Request;

use App\Models\Order;

use \App\Modules\Order\Mail\FrontendOrderMail;

class CheckoutController extends \App\Http\Controllers\Controller
{
    protected $repo_order_service;

    public function __construct( \App\Modules\Order\Respository\OrderRespository $order_respository ) {
        $this->repo_order_service = $order_respository;
    }

    public function postCheckout( Request $request )
    {
        //dd( $request->all() );

        $payment_gateways = [ OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE, OrderRespository::$FOR_ORDER_TYPE_PAY_BY_PAYPAL ];

        $validator_rules = [
            'payment_method.method' => 'required|in:' . implode( ',', $payment_gateways ),
            'order_note'            => 'max:250',
            'i_agree'               => 'required',
        ];

        //For Billing Address
        $for_billing_validate = [
            'billing.first_name' => 'required|max:20',
            'billing.last_name'  => 'required|max:20',
            'billing.email'      => 'required|email|max:40',
            'billing.phone'      => 'required|max:20',
            'billing.address'    => 'max:250',
            'billing.country'    => 'required|max:15',
            'billing.state'      => 'max:15',
            'billing.city'       => 'max:15',
            'billing.zipcode'    => 'max:10',
            'billing.company'    => 'max:30',
        ];

        //$validator_rules = array_merge($validator_rules, $for_billing_validate);

        //For Payment Method Rules
        if( $request->payment_method )
        {
            switch ( $request->payment_method['method'] )
            {
                case OrderRespository::$FOR_ORDER_TYPE_PAY_BY_PAYPAL:
                    $for_methods = [
                        'payment_method.pay_by_paypal.card_name'   => 'required|max:20',
                        'payment_method.pay_by_paypal.card_number' => 'required|max:30',
                        'payment_method.pay_by_paypal.card_month'  => 'required|max:2',
                        'payment_method.pay_by_paypal.card_year'   => 'required|max:2',
                        'payment_method.pay_by_paypal.card_cvv'    => 'required|max:4'
                    ];
                    $validator_rules = array_merge($validator_rules, $for_methods);
                break;
                case OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE:
                    $for_methods = [
                        'payment_method.pay_by_stripe.card_name'   => 'required|max:20',
                        'payment_method.pay_by_stripe.card_number' => 'required|max:30',
                        'payment_method.pay_by_stripe.card_month'  => 'required|max:2',
                        'payment_method.pay_by_stripe.card_year'   => 'required|max:2',
                        'payment_method.pay_by_stripe.card_cvv'    => 'required|max:4'
                    ];
                    $validator_rules = array_merge($validator_rules, $for_methods);
                break;
            }
        }

        $validator_messages = [

            //For Default
            'payment_method.method' => 'payment method',

            //For Billing
            'billing.first_name' => 'billing first name',
            'billing.last_name'  => 'billing last name',
            'billing.email'      => 'billing email',
            'billing.phone'      => 'billing phone',
            'billing.address'    => 'billing address',
            'billing.country'    => 'billing country',
            'billing.state'      => 'billing state',
            'billing.city'       => 'billing city',
            'billing.zipcode'    => 'billing zip code',
            'billing.company'    => 'billing company name',

            //For Paypal
            'payment_method.pay_by_paypal.card_name'   => 'Holder Name',
            'payment_method.pay_by_paypal.card_number' => 'Card Number',
            'payment_method.pay_by_paypal.card_month'  => 'Expiry Month',
            'payment_method.pay_by_paypal.card_year'   => 'Expiry Year',
            'payment_method.pay_by_paypal.card_cvv'    => 'Security Code',

            //For Stripe
            'payment_method.pay_by_stripe.card_name'   => 'Holder Name',
            'payment_method.pay_by_stripe.card_number' => 'Card Number',
            'payment_method.pay_by_stripe.card_month'  => 'Expiry Month',
            'payment_method.pay_by_stripe.card_year'   => 'Expiry Year',
            'payment_method.pay_by_stripe.card_cvv'    => 'Security Code',
        ];
        //dd($validator_rules);

        $validator = \Validator::make( $request->all(),
            $validator_rules,
            ['i_agree.required' => 'Please Tick above to agree Terms and Conditions'],
            $validator_messages);

        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        //Your shopping cart is empty
        if( \ShoppingCart::getContent()->count() < 1 )
        {
            $request->session()->flash( 'alert-message', [
               'status'  => 'danger',
               'message' => 'Your shopping cart is empty'
           ]);
           return redirect()->back();
        }

        $order = $this->repo_order_service->apiCreateOrder($request, new \App\Models\Order );

        //Fail Orders Errors
        if( isset($order['payment_error']) && $order['payment_error'] )
        {
            $request->session()->flash( 'alert-message', [
               'status'  => 'danger',
               'message' => $order['payment_error']
           ]);
           return redirect()->back();
        }

        $user = \Auth::user();

        //Notify to "Order Email" to User
        if( $user->email  )
        {
            $subject    = 'Your Payment has been received';

            \Mail::to( $user->email )->send( new FrontendOrderMail( 'checkout-order-customer', $subject, $user, [
                'order' => $order
            ]));
            try {

            }
            catch( \Exception $e ) {
                Setting::failedSmtpMailSend( $e->getMessage() );
            }
        }

        //Notify to "Order Email" to Admin
        $admin_emails = \App\Models\User::getAdminEmailsList();

        if( count($admin_emails) )
        {
            $subject    = 'New Payment has been received from '. $user->email;
            foreach ( $admin_emails as $email )
            {
                try {
                    \Mail::to( $email )->send( new FrontendOrderMail( 'checkout-order-admin', $subject, $user, [
                        'order' => $order
                    ]));
                }
                catch( \Exception $e ) {
                    Setting::failedSmtpMailSend( $e->getMessage() );
                }
            }
        }

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your order is being processed by our delivery team. You will receive a confirmation from us shortly.'
        ]);
        return redirect()->route( front_route( 'user.dashboard' ) );
    }
}
