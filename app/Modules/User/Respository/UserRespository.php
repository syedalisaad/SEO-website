<?php namespace App\Modules\User\Respository;

use App\Models\Hospital;
use App\Models\Order;
use \App\Models\User;
use \App\Models\UserHospitalInfo;
use \App\Models\UserDetail;
use \App\Models\Setting;
use App\Modules\Order\Respository\OrderRespository;
use Carbon\Carbon;
use App\Support\Traits\{UploadableTrait,
    StorageableTrait
};

class UserRespository {
    use UploadableTrait, StorageableTrait;

    private $model = null;

    public function __construct( User $user ) {
        $this->model = $user;
    }

    public function userCreateOrUpdate( $request, User $user )
    {
        $is_create_account = is_null( $user->id );

        //De-Active Stripe Paused Subscription
        $is_active = (int) $request->is_active;
        if ( $user->is_active != $is_active && $user->email_verified_at )
        {
            $subscribe_order = get_current_subscription( $user->id);
            if($subscribe_order) {
                $stripe_trans = $this->forStripePausedSubscription( $user, $is_active );
            }
        }
        $is_password_set = $user->is_password_set;
        if ( $user->is_password_set == 0 ) {
            $random                = \Str::Random( 8 );
            $user->password        = $random;
            $user->is_password_set = 1;
        }
        if ( $request->password ) {
            $user->password = $request->password;
        }

        $user->first_name = $request->first_name ?: '';
        $user->last_name  = $request->last_name ?: '';
        //$user->username   = $request->username??'';
        $user->email     = $request->email;
        $user->user_type = $request->user_type ?: User::$USER_USER;
        $user->phone     = $request->phone;
        $user->age       = $request->age ?: '';
        $user->is_active = (int) $request->is_active;

        /**
         * Agent Profile Image
         */
        if ( $request->hasFile( 'source_image' ) ) {

            $file      = $request->file( 'source_image' );
            $file_name = ( $request->first_name . ' ' . $request->last_name );

            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( User::$storage_disk );
            if ( $user->source_image ) {
                $this->fileDeleteFromDisk( $user->source_image, User::$storage_disk );
            }

            // Make a file path where file will be stored [ file name + file extension]
            $user->source_image = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();

            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, User::$storage_disk, $user->source_image );
        }

        if ( $is_create_account ) {
            $user->email_verified_at = date( 'Y-m-d H:i:s' );
            $user->remember_token    = \Str::random( 30 );
        }

        $user->save();

        UserDetail::updateOrCreate( [ 'user_id' => $user->id ], [
            'hospital_id'          => $request->hospital_id,
            'is_hospital_approved' => (int) $request->is_active
        ]);

        if ( $is_create_account )
        {
            $setings = get_site_settings();
            $subject = 'Congratulations, Your account has been created successfully by ' . ( $setings['sites']['site_name'] ?? 'Site Name' ) . '!';

            try {
                \Mail::to( $user->email )->send( new \App\Modules\User\Mail\UserMail( 'registration-complete', $subject, $user, [
                    'password' => $request->password
                ]));
            }
            catch( \Exception $e ) {
                Setting::failedSmtpMailSend( $e->getMessage() );
            }
        }
        else {
            if ($user->is_active == 1 && $is_password_set == 0)
            {
                $subject = "Your account has been approved";
                try {
                    \Mail::to( $user->email )->send( new \App\Modules\User\Mail\UserMail( 'new-password', $subject, $user, [
                        'password' => $random
                    ]));
                }
                catch( \Exception $e ) {
                    Setting::failedSmtpMailSend( $e->getMessage() );
                }
            }

            if ($request->password)
            {
                $subject = "Your account password has been updated";
                try {
                    \Mail::to( $user->email )->send( new \App\Modules\User\Mail\UserMail( 'new-password', $subject, $user, [
                        'password' => $request->password
                    ]));
                }
                catch( \Exception $e ) {
                    Setting::failedSmtpMailSend( $e->getMessage() );
                }
            }
        }



        return $user;
    }

    public function userUpdateSetting( $request, User $user ) {
        $user->first_name = $request->first_name ?: '';
        $user->last_name  = $request->last_name ?: '';
        $user->phone      = $request->phone;
        if ( $request->hasFile( 'source_image' ) ) {
            $file      = $request->file( 'source_image' );
            $file_name = ( $request->first_name . ' ' . $request->last_name );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( User::$storage_disk );
            if ( $user->source_image ) {
                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $user->source_image, User::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $user->source_image = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, User::$storage_disk, $user->source_image );
        }
        $user->save();

        return $user;
    }

    public function userRegister( $request ) {
        $token                = \Str::Random( 6 );
        $password             = $request->password ?: '123##!23';
        $user                 = new User;
        $user->first_name     = $request->first_name ?: null;
        $user->last_name      = $request->last_name ?: null;
        $user->email          = $request->email;
        $user->password       = $password;
        $user->user_type      = User::$USER_USER;
        $user->ip_address     = \Request::getClientIp();
        $user->phone          = $request->phone;
        $user->verifytoken    = $token;
        $user->is_active      = 0;
        $user->remember_token = \Str::random( 30 );
        $user->save();
        $extras = $request->extras ?: null;
        UserDetail::updateOrCreate( [ 'user_id' => $user->id ], [
            'hospital_id' => $request->hospital_id ?: null,
            'extras'      => $extras
        ] );

        return $user;
    }

    public function hospitalCreateOrUpdateAdditionalDetails( $request, $hospitalInfo = null ) {


        $ref_url     = $request->ref_url;
        $user_id     = auth()->user()->id;
        $hospital_id = $request->hospital_id;
        if ( $request->hasFile( 'logo_image' ) ) {

            $file      = $request->file( 'logo_image' );
            $file_name = ( $request->logo_image . 'logo_image' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->logo_image ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->logo_image, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $logo_image = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $logo_image );
        }
        if ( $request->hasFile( 'share_image' ) ) {

            $file      = $request->file( 'share_image' );
            $file_name = ( $request->share_image . 'share_image' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->share_image ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->share_image, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $share_image = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $share_image );
        }
        if ( $request->hasFile( 'right_image' ) ) {

            $file      = $request->file( 'right_image' );
            $file_name = ( $request->right_image . 'right_image' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->right_image ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->right_image, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $right_image = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $right_image );
        }
        //        video upload
        if ( $request->hasFile( 'video_one' ) ) {

            $file      = $request->file( 'video_one' );
            $file_name = ( $request->video_one . 'video_one' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->video_one ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->video_one, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $video_one = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $video_one );
        }
        if ( $request->hasFile( 'video_two' ) ) {

            $file      = $request->file( 'video_two' );
            $file_name = ( $request->video_two . 'video_two' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->video_two ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->video_two, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $video_two = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $video_two );
        }
        if ( $request->hasFile( 'video_three' ) ) {

            $file      = $request->file( 'video_three' );
            $file_name = ( $request->video_three . 'video_three' );
            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( Hospital::$storage_disk );
            if ( $request->video_three ) {

                // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
                $this->fileDeleteFromDisk( $request->video_three, Hospital::$storage_disk );
            }
            // Make a file path where file will be stored [ file name + file extension]
            $video_three = \Str::slug( $file_name ) . '_' . time() . "." . $file->getClientOriginalExtension();
            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne( $file, Hospital::$storage_disk, $video_three );
        }
        $user_change_details = false;
        $is_publish =   0;
        if ( ! empty( $hospitalInfo ) ) {
            $is_approved = $hospitalInfo->is_approved;
            if($hospitalInfo->is_approved==1){
                $is_publish = $request->is_publish ??  0;
            }

        }
        $extra = [
            'video_one_status' => $request->video_one_status ?? 0,
            'video_one_youtube' => $request->video_one_youtube ?? null,
            'video_two_status' => $request->video_two_status ?? 0,
            'video_two_youtube' => $request->video_two_youtube ?? null,
            'video_three_status' => $request->video_three_status ?? 0,
            'video_three_youtube' => $request->video_three_youtube ?? null,
        ];
        $hospital_info_save = UserHospitalInfo::updateOrCreate( [
            'user_id'     => $user_id,
            'hospital_id' => $hospital_id,
        ], [
            'phone_number' => $request->phone,
            'name'         => $request->hospital_name,
            'ref_url'      => $ref_url,
            'logo_image'   => ( $logo_image ) ?? $hospitalInfo->logo_image,
            //'share_image'  => ( $share_image ) ?? $hospitalInfo->share_image,
            'right_image'  => ( $right_image ) ?? $hospitalInfo->right_image,
            'video_one'    => ( $video_one ) ?? $hospitalInfo->video_one ?? null,
            'video_two'    => ( $video_two ) ?? $hospitalInfo->video_two ?? null,
            'video_three'  => ( $video_three ) ?? $hospitalInfo->video_three ?? null,
            'is_publish'   => $is_publish ?? 0,
            'is_approved'  => $is_approved ?? 0,
            'extras'  => $extra
        ] );
        $facility_name = $hospital_info_save->hospital->facility_name;
        $data            = $hospital_info_save;
        $data['approval_required']   = false;
        if ( $request->new_user ) {
            $subject         = "[" . $facility_name . "] - Content has been submitted made by " . auth()->user()->email;
            $order           = Order::where( 'user_id', auth()->user()->id )->whereDate( 'expire_package', '>=', Carbon::now() )->latest( 'expire_package' )->first();
            $video           = $order->hasOneOrderItem->product->extras;
            $data['h6']      .= null;
            $data['h4']      .= 'Content Approval Required!';
            $data['content'] .= '<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 25px 0 0; width: 100%;"> The approval is required on the following content edited by ' . auth()->user()->email . '</span>';
            $data['video']   = $video;
            $data['approval_required']   = true;
        } else if ( $user_change_details == true ) {
            $subject         = "[" . $facility_name . "] - Changes have been made by " . auth()->user()->email;
            $order           = Order::where( 'user_id', auth()->user()->id )->whereDate( 'expire_package', '>=', Carbon::now() )->latest( 'expire_package' )->first();
            $video           = $order->hasOneOrderItem->product->extras;
            $data['h6']      .= null;
            $data['h4']      .= 'Content Changes have been Published!';
            $data['content'] .= '<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 25px 0 0; width: 100%;"> The approval is required on the following content edited by ' . auth()->user()->email . '</span>';
            $data['video']   = $video;
        }
        else if ( $is_publish == 1 ) {
            $subject         = "[$facility_name] - Content has been published by " . auth()->user()->email;
            $order           = Order::where( 'user_id', auth()->user()->id )->whereDate( 'expire_package', '>=', Carbon::now() )->latest( 'expire_package' )->first();
            $video           = $order->hasOneOrderItem->product->extras;
            $data['h6']      .= null;
            $data['h4']      .= 'Content Published!';
            $data['content'] .= '<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 25px 0 0; width: 100%;"> The following approved content is published by ' . auth()->user()->email . '</span>';
            $data['video']   = $video;
        } else {
            $subject         = "[$facility_name] - Content has been unpublished by " . auth()->user()->email;
            $data['h6']      .= null;
            $data['h4']      .= 'Content Unpublished!';
            $data['content'] .= '<span style="font-size: 16px;  line-height: 28px; color: #000; margin: 25px 0 0; width: 100%;"> The following approved content is unpublished by ' . auth()->user()->email . '</span>';
            $order           = Order::where( 'user_id', auth()->user()->id )->whereDate( 'expire_package', '>=', Carbon::now() )->latest( 'expire_package' )->first();
            $video           = $order->hasOneOrderItem->product->extras;
            $data['video']   = $video;
        }




        try {
            $setting = Setting::where( 'key', 'sites' )->first();
            \Mail::to( $setting->value['email_support'] )->send( new \App\Modules\User\Mail\UserMail( 'dashboard-user-email', $subject, $data ) );
        } catch( \Exception $e ) {
            \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
        }

        return [ 'user_change_details' => $user_change_details, 'hospital' => $hospital_info_save->hospital ];
    }

    /*
     * Add Address Billing & Shippping (Create or Update)
     *
     * @param Postdata $request
     * @param For Type (Billing, Shipping)
     *
     */
    public function forBillingShippingCreateOrUpdate( $postdata, $for_type ) {
        $address = UserAddress::updateOrCreate( [ 'user_id' => $postdata['user_id'], 'for_type' => $for_type ], [
            'first_name' => $postdata['first_name'],
            'last_name'  => $postdata['last_name'],
            'email'      => $postdata['email'],
            'phone'      => $postdata['phone'],
            'country'    => $postdata['country'] ?? '',
            'state'      => $postdata['state'] ?? '',
            'city'       => $postdata['city'] ?? '',
            'zipcode'    => $postdata['zipcode'] ?? '',
            'company'    => $postdata['company'] ?? '',
            'address'    => $postdata['address'],
            'ip_address' => \Request::getClientIp(),
            'for_type'   => $for_type,
            'is_default' => 1
        ] );

        return $address;
    }

    /*
     * Add Address Billing & Shippping (Create or Update)
     *
     * @param Postdata $request
     * @param For Type (Billing, Shipping)
     *
     */
    public function forCustomerIdBillingCreateOrUpdate( $for_type, $billing_id, $customer_id ) {
        $billing = UserAddress::find( $billing_id );
        $extras  = $billing->extras;
        //Add Payment Customer Id [stripe_customer_id, paypal_customer_id]
        $extras[ $for_type ] = $customer_id;
        $billing->extras     = $extras;
        $billing->save();

        return $billing;
    }

    /*
    * Stripe Pause Subscriptions
    *
    * @param Postdata $request
    * @param For Type (Billing, Shipping)
    *
    */
   public function forStripePausedSubscription($user, $status )
   {
       $stripe_client  = getStripeClient();

       if( !$stripe_client instanceof \Stripe\StripeClient ) {
           return $stripe_client;
       }

       $order = $user->user_order;
       if ( !$order )
       {
           return [
               'transaction_error' => 'Package does not exist'
           ];
       }

       $subscription    = $order->transaction_detail;
       $subscription_id = $subscription['id'] ?? null;

       if( !$subscription_id )
       {
           return [
              'transaction_error' => 'Package subscription does not exist'
          ];
       }

       $ac_collection = [ 'behavior' => 'void']; // when account de-active

       // when account re-active
       if( $status == 1 )
       {
           $ac_collection = [
                'behavior' => 'keep_as_draft',
                'resumes_at' => time()
            ];
       }

       $pause_collection = $stripe_client->subscriptions->update( $subscription_id, [
           'metadata'         => [ 'order_id' => $order->id ],
           'pause_collection' => $ac_collection
       ]);

       $stripe_serialize = $pause_collection->jsonSerialize();

       $extras = $order->extras;
       $extras['payment_info'][OrderRespository::$FOR_ORDER_TYPE_PAY_BY_STRIPE] = $stripe_serialize;

       $order->invoice_id           = $stripe_serialize['latest_invoice'];
       $order->subscription_id      = $stripe_serialize['id'];
       $order->current_period_start = Carbon::parse($stripe_serialize['current_period_start'])->format('Y-m-d H:i:s');
       $order->current_period_end   = Carbon::parse($stripe_serialize['current_period_end'])->format('Y-m-d H:i:s');
       $order->expire_package       = Carbon::parse($stripe_serialize['current_period_end'])->format('Y-m-d H:i:s');
       $order->extras               = $extras;
       $order->save();

       return TRUE;
   }
}
