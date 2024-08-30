<?php namespace App\Support\Repository;

use \App\Models\User;
use \App\Models\UserDetail;

use App\Support\Traits\{
    UploadableTrait,
    StorageableTrait
};

class UserRepository  {

    use UploadableTrait, StorageableTrait;

    static public $USER_ADMIN   = 0;
    static public $USER_USER    = 1;

    static public $storage_disk = 'users';

    private $model = null;

	public function __construct(User $user)
    {
        $this->model = $user;
	}

	public function agentCreateOrUpdate($request, Agent $agent )
    {
        $is_create_account      = is_null($agent->id);

        if( $request->password ) {
            $agent->password = \Hash::make($request->password);
        }

        $phone = ltrim($request->phone, '+');

        $agent->first_name = $request->first_name;
        $agent->last_name  = $request->last_name;
        $agent->username   = $request->username??'';
        $agent->email      = $request->email;
        $agent->phone      = $phone;
        $agent->is_active  = (int) $request->is_active;

        /**
         * Agent Profile Image
         */
        if ($request->hasFile('source_image'))
        {
            $file       = $request->file('source_image');
            $file_name  = ($request->first_name .' '. $request->last_name);

            // Make a folder path where file will be stored [ Folder + Storage = public + Disk = local]
            $this->findOrCreateDirectory( self::$storage_disk );

            // Delete a file path where image will be stored [ file name + Media + Storage = public + Disk = local]
            $this->fileDeleteFromDisk($agent->source_image, self::$storage_disk);

            // Make a file path where file will be stored [ file name + file extension]
            $agent->source_image = \Str::slug( $file_name ) . '_'. time(). "." . $file->getClientOriginalExtension();

            // Store a file path where image will be stored [ File Closure + file name + Media + Storage = public + Disk = local]
            $this->uploadOne($file, self::$storage_disk, $agent->source_image );
        }

        if( $is_create_account ) {
            $agent->user_type          = self::$USER_AGENT;
            $agent->email_verified_at  = date( 'Y-m-d H:i:s' );
            $agent->remember_token     = \Str::random( 30 );
            $agent->is_active          = 1;
        }
        $agent->save();

        if( $is_create_account )
        {
            $setings  = getSiteSettings();
            $subject  = 'Congratulations, now you are a member of ' . ( $setings['sites']['site_name'] ?? 'Site Name' ) . '!';

            \Mail::to( $agent->email )->send( new \App\Mail\UserMail( 'registration-complete', $subject, $agent ) );
        }

        /*
         * Company Logo
         * */

        if( isset($request->extras['company']) ) {
            $request->extras = array_merge( $request->extras, array(
                'company' => $this->_uploadCompanyLogo( $request->extras['company'], $agent )
            ));
        }

        UserDetail::updateOrCreate(['user_id' => $agent->id],[
            'about_desc'         => $request->about_desc,
            'address'            => $request->address ?: null,
            'address_coordinate' => $request->address_coordinate ?: null,
            'website'            => $request->website ?: null,
            'extras'             => $request->extras ?: null
        ]);

        return $agent;
    }

	/*
     * Approve Account
	 *
	 * @param User $user
	 *
     */
    public function approvedAccount( User $user )
    {
        $user->is_active            = 1;
        $user->email_verified_at    = date( 'Y-m-d H:i:s' );
        $user->save();

        //Notifications
        $subject = 'Account Application Approved';
        \Mail::to( $user->email )->send( new \App\Mail\UserMail( 'account-approved', $subject, $user ) );

        return true;
    }

    /*
    * User Update Details
    * @param User $user
    * @param Request $request
    */
    public function userDetailCreateOrUpdate(User $user, $request)
    {
        $transaction = UserDetail::updateOrCreate(['user_id' => $user->id],[
            'about_desc'         => $request->about_desc ?: null,
            'address'            => $request->address ?: null,
            'address_coordinate' => $request->address_coordinate ?: null,
            'website'            => $request->website ?: null,
            'extras'             => $request->extras ?: null
        ]);

        return $transaction;
    }
}
