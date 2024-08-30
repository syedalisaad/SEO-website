<?php namespace App\Modules\User\Controllers\Frontend;

use App\Models\Hospital;
use App\Models\Order;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\UserHospitalInfo;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Page;
use App\Models\StripeProduct;
use DB;

class UserController extends \App\Http\Controllers\Controller {
    use AuthenticatesUsers;

    protected $repo_service;
    public $module = 'User';

    /**
     * Where to redirect users after login.
     * @var string
     */
    protected $redirectTo = '/packages';
    protected $redirectToLogin = '/login';

    public function __construct( \App\Modules\User\Respository\UserRespository $user_respository ) {
        $this->repo_service    = $user_respository;
        $this->redirectTo      = '/packages';
        $this->redirectToLogin = route( front_route( 'user.login' ) );
    }

    /**
     * Show the application "Login"
     */
    public function getLogin() {
        if ( auth()->check() ) {
            return redirect( $this->redirectTo );
        }
        $banner = 2;

        return view( frontend_module_view( 'auth.login', $this->module ), compact( 'banner' ) );
    }

    /**
     * Handle a "login" request to the user.
     */
    public function postLogin( Request $request ) {

        $this->validateLogin( $request );
        $details          = $request->only( 'email', 'password' );
        $details['email'] = $request->email;
        $is_remember      = (bool) ( $request->remember ?: 0 );
        //$details['is_active'] = 1;
        $details['user_type'] = User::$USER_USER;
        if ( auth()->attempt( $details, $is_remember ) ) {
            $userDetails = UserDetail::where( 'user_id', auth()->user()->id )->first();
            if ( auth()->user()->is_active == 0 || $userDetails->is_hospital_approved == 0 ) {
                $email = User::isAdmin()->first()->email;
                auth()->logout();
                $content = "<strong>Account Deactivated</strong> <br> Your account has been disabled, If you have any questions or concerns, you can contact admininistrator <a href='mailto:%s'>%s</a>";
                \Session::flash( 'alert-message', [
                    'status'  => 'warning',
                    'message' => sprintf( $content, $email, $email )
                ] );

                //\Redirect::to( 'login' )->send();
                return redirect()->to( 'login' );
            }

            return $this->sendLoginResponse( $request );
        }
        $this->incrementLoginAttempts( $request );

        return $this->sendFailedLoginResponse( $request );
    }

    /**
     * Show the application "Login"
     */
    public function getRegister() {
        if ( auth()->check() ) {
            return redirect( $this->redirectTo );
        }

        $banner = 2;

        return view( frontend_module_view( 'auth.register', $this->module ), compact( 'banner' ) );
    }

    /**
     * Handle a "register" request to the user.
     */
    public function postRegister( Request $request ) {
        $validator = \Validator::make( $request->all(), [
            'hospital_id' => 'required',
            'first_name'   => 'required|alpha|max:15',
            'last_name'   => 'required|alpha|max:15',
            'email'       => 'required|email|max:50|unique:App\Models\User,email,NULL,id,deleted_at,NULL',
        ], [], [ 'hospital_id' => "Hospital Name" ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }
        $user    = $this->repo_service->userRegister( $request );
        $subject = 'Email Verification';
        try {
            \Mail::to( $user->email )->send( new \App\Modules\User\Mail\FrontendUserMail( 'verify-register', $subject, $user ) );
        } catch( \Exception $e ) {
            \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
        }
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your account has been successfully submitted, check your email for verification. '
        ] );

        return redirect()->route( front_route( 'user.login' ) );
    }

    /**
     * Show the application "Verify Token"
     */
    public function getVerifyToken( Request $request ) {
        $validator = \Validator::make( $request->all(), [
            'verifytoken' => 'required|exists:App\Models\User,remember_token',
        ] );
        if ( $validator->fails() ) {
            return redirect( url( '/' ) );
        }
        $userdata = User::whereRememberToken( $request->get( 'verifytoken' ) )->first();

        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your account has been successfully submitted, check your email for verification. '
        ] );

        return view( frontend_module_view( 'auth.email-verified', $this->module ), compact( 'userdata' ) );
    }

    /**
     * User Verification Email Address
     * Handle a "Verify Email" request to the user.
     */
    public function getEmailVerification( $token ) {

        $page_title = 'Email Verified';
        $user       = User::where( 'verifytoken', $token )->first();

        if ( $user ) {
            $user                    = User::find( $user->id );
            $user->email_verified_at = \Carbon\Carbon::now();
            $user->verifytoken       = null;
            $user->update();
            $subject = 'Email verification process has been completed';
            $data    = $user;
            try {
                $setting = Setting::where( 'key', 'sites' )->first();
                \Mail::to( $setting->value['email_support'] )->send( new \App\Modules\User\Mail\FrontendUserMail( 'account-is-verified', $subject, $data ) );
            } catch( \Exception $e ) {
                \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
            }

            return view( frontend_module_view( 'auth.email-verified', $this->module ), compact( 'page_title' ) );
        } else {
            abort( '404' );
        }
    }

    /**
     * Show the application "Forgot Password"
     */
    public function getForgot() {
        $banner = 2;

        return view( frontend_module_view( 'auth.reset', $this->module ), compact( 'banner' ) );
    }

    /**
     * Handle a "Forgot Password" request to the user.
     */
    public function postForgot( Request $request ) {
        $validator        = \Validator::make( $request->all(), [
            'email' => 'required|email|exists:App\Models\User,email,deleted_at,NULL,user_type,2',
        ], [
            'email.exists' => 'The email does not exist in our system.'
        ] );
        $validator_active = \Validator::make( $request->all(), [
            'email' => 'required|email|exists:App\Models\User,email,is_active,1',
        ], [
            'email.exists' => 'The email is not active please contact us.'
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }
        if ( $validator_active->fails() ) {
            return redirect()->back()->withErrors( $validator_active )->withInput();
        }
        $user  = User::whereEmail( $request->email )->first();
        $email = $user->email;
        $token = \Str::Random( 6 ); //change 60 to any length you want
        DB::table( 'password_resets' )->insert( [
            'email'      => $email,
            'token'      => $token,
            'created_at' => \Carbon\Carbon::now()
        ] );
        $subject = 'Reset Your Password';
        try {
            \Mail::to( $user->email )->send( new \App\Modules\User\Mail\FrontendUserMail( 'send-reset-password', $subject, $user, [ 'token' => $token ] ) );
        } catch( \Exception $e ) {
            \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
        }
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Please check your email to get reset password link!'
        ] );

        return redirect()->back();
    }

    /**
     * Show the application "Reset - New Password"
     */
    public function postResetNewPassword( Request $request, $token ) {
        $reset_builder = DB::table( 'password_resets' )->whereToken( $token );
        $reset_now     = $reset_builder->first();
        if ( null == $reset_now ) {
            abort( 404 );
        }
        $rules = \Validator::make( $request->all(), [
            'password'    => 'required|min:8|max:20|required_with:confirm_password|same:repeat_password',
            'repeat_password' => 'required|max:20',
        ] );
        if ( $rules->fails() ) {
            return redirect()->back()->withErrors( $rules )->withInput();
        }
        $user           = User::whereEmail( $reset_now->email )->first();
        $user->password = $request->password;
        $user->save();
        //Reset link Delete
        $reset_builder->delete();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your password has been changed successfully.'
        ] );

        return redirect()->route( front_route( 'user.login' ) );
    }

    /**
     * Handle a "Reset Password" request to the user.
     */
    public function getResetPassword( Request $request, $token ) {
        $reset = \DB::table( 'password_resets' )->whereToken( $token )->first();
        if ( null == $reset ) {
            abort( 404 );
        }
        $user = User::whereEmail( $reset->email )->first();

        return view( frontend_module_view( 'auth.new-password', $this->module ), compact( 'reset', 'user' ) );
    }

    /**
     * Show the application "Profile Settings"
     */
    public function getEditProfile() {

        if ( ! auth()->check() ) {

            return redirect( $this->redirectToLogin );
        }
        if(auth()->user()->id){
            $user = User::where('id',auth()->user()->id)->whereNotNull('deleted_at')->first();
            if($user){
                auth()->logout();
                return redirect( $this->redirectToLogin );
            }
        }
        $banner = 2;
        $data   = User::findOrFail( auth()->user()->id );

        return view( frontend_module_view( 'edit-profile', $this->module ), compact( 'data', 'banner' ) );
    }

    /**
     * POST the application "Profile Settings"
     * Handle a "Profile Settings" request to the user.
     */
    public function postEditProfile( Request $request ) {


        $rules = \Validator::make( $request->all(), [
            'first_name'   => 'required|alpha|max:10',
            'last_name'    => 'required|alpha|max:10',
            'phone'        => 'required|max:20',
            'source_image' => 'image|mimes:jpeg,png,jpg,gif,webp|max:40960',
        ], [], [ 'source_image' => 'Profile Image should be image' ] );
        if ( $rules->fails() ) {
            return redirect()->back()->withErrors( $rules )->withInput();
        }
        $user = User::findOrFail( auth()->user()->id );
        $user = $this->repo_service->userUpdateSetting( $request, $user );
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Setting has been successfully saved'
        ] );

        return redirect()->back();
    }

    /**
     * Show the application "Chanage Password"
     */
    public function getChangePassword() {
        if ( ! auth()->check() ) {
            return redirect( $this->redirectToLogin );
        }
        if(auth()->user()->id){
            $user = User::where('id',auth()->user()->id)->whereNotNull('deleted_at')->first();
            if($user){
                auth()->logout();
                return redirect( $this->redirectToLogin );
            }
        }
        $banner = 2;

        return view( frontend_module_view( 'change-password', $this->module ), compact( 'banner' ) );
    }

    /**
     * Show the application "Payment
     */
    public function getPayment() {
        if ( ! auth()->check() ) {
            return redirect( $this->redirectToLogin );
        }
        if(auth()->user()->id){
            $user = User::where('id',auth()->user()->id)->whereNotNull('deleted_at')->first();
            if($user){
                auth()->logout();
                return redirect( $this->redirectToLogin );
            }
        }
        $banner = 2;

        return view( frontend_module_view( 'payment', $this->module ), compact( 'banner' ) );
    }

    public function getUnsubscribePackage( Request $request, $order_id )
    {

//        $order = Order::findOrFail($order_id);
//
//        dd($order->transaction_detail);
//
//
//        $strip_client =getStripeClient();


    }

    /**
     * Show the application "package"
     */
    public function getPackages() {

        if ( ! auth()->check() ) {
            return redirect( $this->redirectToLogin );
        }

        $banner          = 2;
        $package_details = StripeProduct::getStripeProductsList();
        /*dump(StripeProduct::$package_details);
        dd($package_details);*/

        return view( frontend_module_view( 'packages', $this->module ), compact( 'banner', 'package_details' ) );
    }

    /**
     * POST the application "Change Password"
     * Handle a "Change Password" request to the user.
     */
    public function postChangePassword( Request $request ) {
        if ( ! auth()->check() ) {
            return redirect()->route( front_route( 'user.login' ) );
        }
        $rules = \Validator::make( $request->all(), [
            'new_password'     => 'required|min:8|max:20|required_with:confirm_password|same:confirm_passowrd',
            'confirm_passowrd' => 'required|max:20',
        ] );
        if ( $rules->fails() ) {
            return redirect()->back()->withErrors( $rules )->withInput();
        }
        $user           = User::whereEmail( auth()->user()->email )->first();
        $user->password = $request->new_password;
        $user->save();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your password has been changed successfully.'
        ] );

        return redirect()->route( front_route( 'user.change_password' ) );
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout( Request $request ) {
        auth()->logout();

        return redirect( '/' );
    }

    public function postShareImageUpdate(Request $request)
    {
        $user = auth()->user();
        $user_id       = $request->user_id;
        $hospital_id   = $request->hospital_id;
        $share_image64 = $request->share_image64;
        $share_image = \Str::slug($user->full_name).'-'.time().'.png';

        if( $share_image64 ){

            $storage_disk = public_path( 'storage/' . Hospital::$storage_disk . '/' . $share_image );
            //dd($storage_disk);

            \Image::make(file_get_contents($share_image64))->save( $storage_disk );

            $hospital_info = UserHospitalInfo::updateOrCreate(['user_id' => $user_id, 'hospital_id' => $hospital_id ], [
                'share_image'  => $share_image
            ]);

            return response()->json([
                'success' => 'Share image successfully uploaded.',
                //'image_source' => 'http://localhost/goodhospitalbadhospital/storage/hospitals/murtaza-pervez-1647448657.png'
                'image_source' => $hospital_info->image_url_share
            ]);
        }

        return response()->json(['error' => 'Invalid image']);
    }

    //        dashboard update hospital details
    public function postdashboardUpdate( Request $request ) {

        $user_id      = auth()->user()->id;
        $hospital_id  = $request->hospital_id;
        $hospitalInfo = UserHospitalInfo::where( [ 'user_id' => $user_id, 'hospital_id' => $hospital_id ] )->first();
        if ( empty( $hospitalInfo ) ) {

            $validator = \Validator::make( $request->all(), [
                'hospital_name' => 'required',
                'phone'         => 'required',
                'ref_url'       => 'required|url',
                'logo_image'    => 'required|image|dimensions:min_width=300,min_height=300|mimes:jpeg,png,jpg,gif,webp|max:40960',
                //'share_image'    => 'required|image|dimensions:min_width=180,min_height=180|mimes:jpeg,png,jpg,gif,webp|max:40960',
                'video_one'     => 'mimes:mp4,mov,ogg|max:40960',
                'video_two'     => 'mimes:mp4,mov,ogg|max:40960',
                'video_three'   => 'mimes:mp4,mov,ogg|max:40960',
                'right_image'   => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:40960',
                'video_one_youtube'       => 'nullable|url',
                'video_two_youtube'       => 'nullable|url',
                'video_three_youtube'       => 'nullable|url',
            ], [], [
                'ref_url'     => 'Website URL.',
                'right_image' => 'Main image.',
                'video_one_youtube'       => 'youtube',
                'video_two_youtube'       => 'youtube',
                'video_three_youtube'       => 'youtube',
            ] );
        } else {

            $validator = \Validator::make( $request->all(), [
                'hospital_name' => 'required',
                'phone'         => 'required',
                'ref_url'       => 'required|url',
                'logo_image'    => 'dimensions:min_width=300,min_height=300image|mimes:jpeg,png,jpg,gif,webp|max:40960',
                'right_image'   => 'image|mimes:jpeg,png,jpg,gif,webp|max:40960',
                //'share_image'    => 'required|image|dimensions:min_width=180,min_height=180|mimes:jpeg,png,jpg,gif,webp|max:40960',
                'video_one'     => 'mimes:mp4,mov,ogg|max:40960',
                'video_two'     => 'mimes:mp4,mov,ogg|max:40960',
                'video_three'   => 'mimes:mp4,mov,ogg|max:40960',
                'video_one_youtube'       => 'nullable|url',
                'video_two_youtube'       => 'nullable|url',
                'video_three_youtube'       => 'nullable|url',
            ], [], [
                'ref_url'     => 'Website URL.',
                'right_image' => 'Main image.',
                'video_one_youtube'       => 'youtube',
                'video_two_youtube'       => 'youtube',
                'video_three_youtube'       => 'youtube',
            ] );
        }
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }

        if ( empty( $hospitalInfo ) ) {
            $result = $this->repo_service->hospitalCreateOrUpdateAdditionalDetails( $request, $hospitalInfo );
        } else {
            $result = $this->repo_service->hospitalCreateOrUpdateAdditionalDetails( $request, $hospitalInfo );
        }

        if($result['user_change_details'] ==true)
        {
            $request->session()->flash( 'alert-message', [
                'status'  => 'success',
                'message' => "Content has been unpublished"
            ] );
        }
        else if ( $request->is_publish && $request->is_publish == 1 ) {
            $request->session()->flash( 'alert-message', [
                'status'  => 'success',
                'message' => 'Content have been published! see changes <a href="'.route(front_route("page.unpaid"),$result['hospital']->slug).' "> here</a>'
            ] );
        } else {
            $request->session()->flash( 'alert-message', [
                'status'  => 'success',
                'message' => "Content has been unpublished."
            ] );
        }


        return redirect()->back();
    }

    /**
     * success response method stripe paymet datewau.
     * @return \Illuminate\Http\Response
     */
    public function postStripe( Request $request )
    {
        \Stripe\Stripe::setApiKey( env( 'STRIPE_SECRET' ) );

        \Stripe\Charge::create( [
            "amount"      => 100 * 100,
            "currency"    => "usd",
            "source"      => $request->stripeToken,
            "description" => "This payment is tested purpose phpcodingstuff.com"
        ]);

        \Session::flash( 'success', 'Payment successful!' );

        return back();
    }

    /**
     * Show the application payment terms.
     */
    public function getTerms()
    {
        $data         = Page::isActive()->whereSlug( Page::$PAGE_PAYMENT_TERMS_AND_CONDITION )->firstOrFail();
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'package-term', $this->module ), compact( 'data', 'seo_metadata' ) );
    }

    /**
     * Show the application system price Email.
     */
    public function postSystemPrice( Request $request )
    {
        $validator = \Validator::make( $request->all(), [
            'name'  => 'required',
            'email' => 'required|email',
            'phone' => 'required||min:10',
        ]);

        if ( $validator->fails() ) {
            return response()->json( [ 'error' => $validator->errors(), 'status' => false ] );
        }

        $setting = Setting::where( 'key', 'sites' )->first();
        $subject = "System Price";
        $data    = $request;

        try {
            \Mail::to( $setting->value['email_opperations'] )->send( new \App\Modules\User\Mail\UserMail( 'system-price', $subject, $data ) );
        }
        catch( \Exception $e ){
            \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
        }

        return response()->json([
            'status'  => true,
            'message' => 'Thank you! we will get back to you soon.'
        ]);
    }

    public function ajaxRemoveVideo( Request $request )
    {
        $path          = storage_path( 'hospitals' );
        $video         = $request->video;
        $hospital_info = UserHospitalInfo::find( $request->id );

        if ( $hospital_info && isset( $hospital_info[ $video ] ) && auth()->user() )
        {
            $filename = $path . '/' . $hospital_info[ $video ];

            if ( file_exists( $filename ) ) {
                unlink( $filename );
            }

            $hospital_info->{$video} = null;
            $hospital_info->update();

            return response()->json( [ 'message' => 'File is deleted', 'status' => true ] );
        }

        return response()->json([ 'message' => 'Resource not found', 'status' => false ]);
    }



    /**
     * send help email.
     */
    public function postHelpEmail( Request $request )
    {

        $validator = \Validator::make( $request->all(), [
            'subject'  => 'required',
            'message' => 'required',
        ]);

        if ( $validator->fails() ) {
            return response()->json( [ 'error' => $validator->errors(), 'status' => false ] );
        }

        $setting = Setting::where( 'key', 'sites' )->first();
        $subject = $request->subject;
        $data    = $request;

        try {
            \Mail::to( $setting->value['email_info'] )->send( new \App\Modules\User\Mail\UserMail( 'help', $subject, $data ) );
        }
        catch( \Exception $e ){
            \App\Models\Setting::failedSmtpMailSend( $e->getMessage() );
        }

        return response()->json([
            'status'  => true,
            'message' => 'Thank you! we will get back to you soon.'
        ]);
    }
}
