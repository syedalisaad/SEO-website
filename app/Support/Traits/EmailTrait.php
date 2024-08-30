<?php namespace App\Support\Traits;

use Illuminate\Support\Facades\Mail;
use \App\Mail\SystemMail;

use App\Notification;
//Ref: https://instamotivehunt.wordpress.com/2018/10/01/dynamic-email-template-in-laravel/

trait EmailTrait  {

    //For Buyer Create New Account - [Frontend]
    public function notify_to_newsletter( $to_sender_email, $user, $data )
    {
        $setings    = get_site_settings();
        $template   = 'newsletter';
        $subject    = $data['subject'] ." - ". $setings['sites']['site_name'];

        Mail::to($to_sender_email)->send(new SystemMail($template, $subject, $user, $data));
    }

    /*
    * Postleads
    * - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
    *
    * 1) Add Postlead: For User [Admin Receive Add Postlead]
    * 2) Prouce New Price: For User [Admin Receive Product "Add New Price"]
    * 3) Product Contacts: For User [Admin Receive Engaged Product (Phone|Chat)]
    * 4) Product Add Review: For User [Admin Receive Product Reviews]
    * 5) Product Review Update: For Admin [Supplier/Buyer Receive Product Reviews]
    *
    **/
    // For User [Admin Receive Add Postlead]
    public function notify_postlead_for_manage( $data )
    {
        //code ...
    }
}
