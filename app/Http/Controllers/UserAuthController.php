<?php namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
use \App\Models\User;
use \App\Models\UserDetail;
use App\Support\Repository\UserRepository;

class UserAuthController extends \App\Http\Controllers\AdminController {
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    public $module = 'Page';
    /**
     * Where to redirect users after login.
     * @var string
     */
    protected $redirectTo = '/user/dashboard';
    protected $mguards = 'user';

    /**
     * Create a new controller instance.
     * @return void
     */
    public function __construct() {
        $this->redirectTo = route( admin_route( 'dashboard' ) );
    }

    /**
     * Show the application's login form.
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm() {
        $page_title   = 'Login';
        $banner       = 1;
        $seo_metadata = $data->seo_metadata ?? [];
        if ( auth()->guard( $this->mguards )->check() ) {
            return redirect()->route( admin_route( 'dashboard' ) );
        }

        return view( frontend_module_view( 'auth.login', $this->module ), compact( 'page_title', 'banner', 'seo_metadata' ) );
    }

    /**
     * Handle a login request to the employee.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login( Request $request ) {


        $this->validateLogin( $request );
        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ( $this->hasTooManyLoginAttempts( $request ) ) {
            $this->fireLockoutEvent( $request );

            return $this->sendLockoutResponse( $request );
        }
        $details              = $request->only( 'email', 'password' );
        $is_remember          = (bool) ( $request->remember ?: 0 );
        $details['is_active'] = 1;
        //        $details['user_type'] = UserRepository::$USER_USER;
        //        if ( auth()->guard( $this->mguards )->attempt( $details, $is_remember ) ) {
        if ( auth()->guard( $this->mguards )->attempt( [ 'email' => $request->email, 'password' => $request->password ] ) ) {

            echo 'user is signin';
            die;

            return $this->sendLoginResponse( $request );
        }
        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts( $request );

        return $this->sendFailedLoginResponse( $request );
    }

    /**
     * Show the application's Verify Email form.
     * @return \Illuminate\Http\Response
     */
    public function showResetForm() {
        $page_title   = 'Reset Password';
        $banner       = 1;
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'auth.reset', $this->module ), compact( 'page_title', 'banner', 'seo_metadata' ) );
    }

    /**
     * Show the application's Reset Password form.
     * @return \Illuminate\Http\Response
     * @method POST
     */
    public function sendPasswordResetToken( Request $request ) {
        $validator        = \Validator::make( $request->all(), [
            'email' => 'required|email|exists:App\Models\User,email',
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
        \Mail::to( $email )->send( new \App\Modules\Page\Mail\PageMail( 'send-reset-password', 'Reset Your Password', $user, [ 'token' => $token ] ) );
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Please check your email to get reset password link!'
        ] );

        return redirect()->back();
    }

    public function getPasswordResetToken( Request $request, $token ) {
        $page_title   = 'Reset Password';
        $banner       = 1;
        $seo_metadata = $data->seo_metadata ?? [];
        $reset        = DB::table( 'password_resets' )->whereToken( $token )->first();
        if ( null == $reset ) {
            abort( 404 );
        }
        $user = User::whereEmail( $reset->email )->first();

        return view( frontend_module_view( 'auth.new-password', $this->module ), compact( 'page_title', 'banner', 'seo_metadata', 'reset', 'user' ) );
    }

    public function postResetNewPassword( Request $request, $token ) {
        $reset_builder = DB::table( 'password_resets' )->whereToken( $token );
        $reset_now     = $reset_builder->first();
        if ( null == $reset_now ) {
            abort( 404 );
        }
        $rules = \Validator::make( $request->all(), [
            'new_password'    => 'required|min:8|max:20|required_with:confirm_password|same:repeat_password',
            'repeat_password' => 'required|max:20',
        ] );
        if ( $rules->fails() ) {
            return redirect()->back()->withErrors( $rules )->withInput();
        }
        $user           = User::whereEmail( $reset_now->email )->first();
        $user->password = $request->new_password;
        $user->save();
        //Reset link Delete
        $reset_builder->delete();
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your password has been changed successfully.'
        ] );

        return redirect()->route( admin_route( 'login' ) );
    }

    /**
     * Log the user out of the application.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function logout( Request $request ) {
        auth()->guard( $this->mguards )->logout();
        $request->session()->invalidate();

        return $this->loggedOut( $request ) ?: redirect( '/' );
    }

    public function register( Request $request ) {

        $validator = \Validator::make( $request->all(), [
            'email' => 'required|email|unique:users',
        ], [
            'email.exists' => 'The email does not exist in our system.',
        ] );
        if ( $validator->fails() ) {
            return redirect()->back()->withErrors( $validator )->withInput();
        }
        $token = \Str::Random( 20 );
        $user  = User::create( [
            //            'first_name'  => $request->first_name,
            //            'last_name'   => $request->last_name,
            'email'       => $request->email,
            //            'phone'       => $request->phone ?? '000-000-0000',
            'user_type'   => 2,
            'is_active'   => 0,
            'verifytoken' => $token,
            'ip_address'  => \Request::getClientIp(),
            'password'    => Hash::make( '123##!23' )
        ] );
        $user_details = UserDetail::create( [
            'hospital_id' =>$request->hospital_id,
            'user_id' =>$user->id,

        ] );
        \Mail::to( $request->email )->send( new \App\Modules\Page\Mail\PageMail( 'email-varification', 'Email Varificaition', $user ) );
        $request->session()->flash( 'alert-message', [
            'status'  => 'success',
            'message' => 'Your account has been successfully submitted, check your email for varification. '
        ] );

        //        $user->markEmailAsVerified();
        return redirect()->route( front_route( 'page.login' ) );
    }

    public function getEmailVerification( $token ) {
        $page_title = 'Email Verified';
        $user       = User::where( 'verifytoken', $token )->first();
        if ( $user ) {
            $user                    = User::find( $user->id );
            $user->email_verified_at = \Carbon\Carbon::now();
            $user->verifytoken       = null;
            $user->update();

            return view( frontend_module_view( 'auth.email-verified', $this->module ), compact( 'page_title' ) );
        } else {
            abort( '404' );
        }
    }

    /**
     * Show the application's regestration form.
     * @return \Illuminate\Http\Response
     */
    public function showRegisterForm() {
        $page_title   = 'Register';
        $banner       = 1;
        $seo_metadata = $data->seo_metadata ?? [];

        return view( frontend_module_view( 'auth.register', $this->module ), compact( 'page_title', 'banner', 'seo_metadata' ) );
    }
}
