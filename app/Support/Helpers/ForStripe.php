<?php
//============================================================+
// File name    : For Stripe
// Created At   : 2021-10

// Description  : Theme includes a variety of global "helper" PHP functions.
// @Author      : Junaid Ahmed
// @github      : https://github.com/xunaidahmed
// -------------------------------------------------------------------

#https://cartalyst.com/manual/stripe/2.0#charges

use App\Models\Setting;


function getStripeConfig() {
    return get_site_settings('payment_gateway')[Setting::$PAYMENT_GATEWAYS['STRIPE']] ?? NULL;
}

function getStripeInitialize(){

    $stripe_info = getStripeConfig();

    if( !(isset($stripe_info['client_id'], $stripe_info['client_secret']) && $stripe_info['client_id'] && $stripe_info['client_secret']) ) {
        return [
            'payment_error' => 'You can generate API keys from the Stripe web interface'
        ];
    }

    \Stripe\Stripe::setClientId($stripe_info['client_id']);
    \Stripe\Stripe::setApiKey($stripe_info['client_secret']);
}

function getStripeClient(){

    $stripe_info = getStripeConfig();

    if( !(isset($stripe_info['client_id'], $stripe_info['client_secret']) && $stripe_info['client_id'] && $stripe_info['client_secret']) ) {
        return [
            'payment_error' => 'You can generate API keys from the Stripe web interface'
        ];
    }

    return new \Stripe\StripeClient(
        $stripe_info['client_secret']
    );
}

function getStripeCustomers(){

    $stripe_client = getStripeClient();

    if( !$stripe_client instanceof Stripe\StripeClient ) {
        return $stripe_client;
    }

    $customers = $stripe_client->customers->all()->data;

    if( count($customers) )
    {
        $data = [];
        foreach( $customers as $row)
        {
            $data[] = [
                'id'      => $row->id,
                'name'    => $row->name,
                'email'   => $row->email,
                'address' => $row->address,
            ];
        }

        return $data;
    }

    return [];
}

function getStripeCustomerBy($value, $key = 'id'){

    $stripe_client = getStripeClient();

    if( !$stripe_client instanceof Stripe\StripeClient ) {
        return $stripe_client;
    }

    $customers = $stripe_client->customers->all([ $key => $value])->data;

    if( count($customers) )
    {
        foreach( $customers as $row)
        {
            return [
                'id'      => $row->id,
                'name'    => $row->name,
                'email'   => $row->email,
                'address' => $row->address,
            ];
        }
    }

    return null;
}

function getStripeInvoiceById( $invoice_id )
{
    $stripe_client = getStripeClient();

    if( $stripe_client instanceof Stripe\StripeClient )
    {
        $invoice = $stripe_client->invoices->retrieve($invoice_id);

        return $invoice->hosted_invoice_url;
    }

    return $stripe_client['payment_error'];
}

function getStripeInvoiceInfoById( $invoice_id )
{
    $stripe_client = getStripeClient();

    if( $stripe_client instanceof Stripe\StripeClient )
    {
        $invoice = $stripe_client->invoices->retrieve($invoice_id);

        return $invoice;
    }

    return $stripe_client['payment_error'];
}
function getStripeSubscriptionById( $subscription_id )
{
    $stripe_client = getStripeClient();

    if( $stripe_client instanceof Stripe\StripeClient )
    {
        return $stripe_client->subscriptions->retrieve($subscription_id);
    }

    return $stripe_client['payment_error'];
}

function getStripeCancelSubscriptionById( $subscription_id )
{
    $stripe_client = getStripeClient();

    if( $stripe_client instanceof Stripe\StripeClient )
    {
        return $stripe_client->subscriptions->cancel($subscription_id);
    }

    return $stripe_client['payment_error'];
}
