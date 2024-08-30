<?php namespace App\Http\Controllers;

use DB;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use \App\Models\User;
use \App\Models\UserDetail;

use App\Support\Repository\UserRepository;

class AdminAuthController extends \App\Http\Controllers\AdminController
{
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo   = '/admin/dashboard';

    protected $mguards      = 'admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->redirectTo = route( admin_route('dashboard') );
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        if(auth()->guard( $this->mguards )->check()) {
            return redirect()->route(admin_route('dashboard'));
        }

        return view( admin_view('auth.login') );
    }

    /**
     * Handle a login request to the employee.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $details        = $request->only('email', 'password');
        $is_remember    = (bool) ($request->remember ?: 0);

        $details['is_active'] = 1;
        $details['user_type'] = UserRepository::$USER_ADMIN;

        if (auth()->guard($this->mguards)->attempt($details, $is_remember)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Show the application's Verify Email form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showResetForm() {
        return view( admin_view( 'auth.reset' ) );
    }

    /**
     * Show the application's Reset Password form.
     *
     * @return \Illuminate\Http\Response
     * @method POST
     */
    public function sendPasswordResetToken(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|exists:App\Models\User,email',
        ], [
            'email.exists' => 'The email does not exist in our system.'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user   = User::whereEmail( $request->email )->first();
        $email  = $user->email;
        $token  = \Str::Random(60); //change 60 to any length you want

        DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => \Carbon\Carbon::now()
        ]);

        \Mail::to($email)->send(new \App\Modules\User\Mail\UserMail('send-reset-password', 'Reset Your Password', $user, ['token' => $token]));

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Please check your email to get reset password link!'
        ]);
        return redirect()->back();
    }

    public function getPasswordResetToken(Request $request, $token)
    {
        $reset = DB::table('password_resets')->whereToken($token)->first();

        if( null == $reset ) {
            abort(404);
        }

        $user = User::whereEmail($reset->email)->first();

        return view( admin_view('auth.new-password'), compact('reset', 'user') );
    }

    public function postResetNewPassword(Request $request, $token)
    {
        $reset_builder  = DB::table('password_resets')->whereToken($token);
        $reset_now      = $reset_builder->first();

        if( null == $reset_now ) {
            abort(404);
        }

        $rules = \Validator::make($request->all(), [
            'new_password'    => 'required|max:20|required_with:confirm_password|same:repeat_password',
            'repeat_password' => 'required|max:20',
        ]);

        if ($rules->fails()) {
            return redirect()->back()->withErrors($rules)->withInput();
        }

        $user = User::whereEmail($reset_now->email)->first();
        $user->password = $request->new_password;
        $user->save();

        //Reset link Delete
        $reset_builder->delete();

        $request->session()->flash('alert-message', [
            'status' => 'success',
            'message'=> 'Your password has been changed successfully.'
        ]);
        return redirect()->route(admin_route('login'));
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        auth()->guard( $this->mguards )->logout();

        $request->session()->invalidate();

        return $this->loggedOut($request) ?: redirect('/');
    }
}
