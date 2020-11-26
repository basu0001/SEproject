<?php

namespace App\Http\Controllers\Auth;

use App\SmUserLog;
use App\SmAcademicYear;
use App\SmGeneralSettings;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use Illuminate\Cache\RateLimiter;
use Illuminate\Auth\Events\Lockout;
use App\Http\Controllers\Controller;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

use App\SmSchool;

class LoginController extends Controller
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

    /**
     * Get the post register / login redirect path.
     *
     * @return string
     */
    public function redirectPath()
    {
        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }

    /**
     * Determine if the user has too many failed login attempts.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function hasTooManyLoginAttempts(Request $request)
    {
        return $this->limiter()->tooManyAttempts(
            $this->throttleKey($request),
            $this->maxAttempts()
        );
    }

    /**
     * Increment the login attempts for the user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function incrementLoginAttempts(Request $request)
    {
        $this->limiter()->hit(
            $this->throttleKey($request),
            $this->decayMinutes()
        );
    }

    /**
     * Redirect the user after determining they are locked out.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['seconds' => $seconds])],
        ])->status(429);
    }

    /**
     * Clear the login locks for the given user credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function clearLoginAttempts(Request $request)
    {
        $this->limiter()->clear($this->throttleKey($request));
    }

    /**
     * Fire an event when a lockout occurs.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function fireLockoutEvent(Request $request)
    {
        event(new Lockout($request));
    }

    /**
     * Get the throttle key for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    protected function throttleKey(Request $request)
    {
        return Str::lower($request->input($this->username())) . '|' . $request->ip();
    }

    /**
     * Get the rate limiter instance.
     *
     * @return \Illuminate\Cache\RateLimiter
     */
    protected function limiter()
    {
        return app(RateLimiter::class);
    }

    /**
     * Get the maximum number of attempts to allow.
     *
     * @return int
     */
    public function maxAttempts()
    {
        return property_exists($this, 'maxAttempts') ? $this->maxAttempts : 5;
    }

    /**
     * Get the number of minutes to throttle for.
     *
     * @return int
     */
    public function decayMinutes()
    {
        return property_exists($this, 'decayMinutes') ? $this->decayMinutes : 1;
    }

    public function login(Request $request)
    {
        // return $request;
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {


            // Start checking subscription module

            if(Auth::user()->role_id != 1){
                if(SmGeneralSettings::isModule('SaasSubscription')== TRUE){

                    if(!\Modules\SaasSubscription\Entities\SmPackagePlan::isSubscriptionAutheticate()){

                        $this->guard()->logout();
                        Toastr::error('You are not allow to login., Please contact with administrator.', 'Failed');
                        return redirect('login');
                    }
                }

            }

            // End checking subscription module

            $school = SmSchool::where('id', Auth::user()->school_id)->first();

            if ($school->active_status == 1) {

                if (Auth::user()->active_status != 0 && Auth::user()->access_status != 0) {

                    if ($school->is_enabled == 'yes') {

                        session(['role_id' => Auth::user()->role_id]);
                        $agent = new Agent();
                        $user_log = new SmUserLog();
                        $user_log->user_id = Auth::user()->id;
                        $user_log->role_id = Auth::user()->role_id;
                        $user_log->school_id = Auth::user()->school_id;
                        $user_log->ip_address = $request->ip();
                        $user_log->user_agent = $agent->browser() . ', ' . $agent->platform();
                        $user_log->save();

                        return $this->sendLoginResponse($request);
                    } else {

                        $this->guard()->logout();
                        Toastr::error('Your Institution is not Approved, Please contact with administrator.', 'Failed');
                        return redirect('login');
                    }
                } else {
                    $this->guard()->logout();
                    Toastr::error('You are not allowed, Please contact with administrator.', 'Failed');
                    return redirect('login');
                }
            } else {
                $this->guard()->logout();
                Toastr::error('Your Institution is not Approved, Please contact with administrator.', 'Failed');
                return redirect('login');
            }
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {

        if (SmGeneralSettings::isModule('Saas') == TRUE) {
            $request->validate(
                [
                    $this->username() => 'required|string',
                    'password' => 'required|string',
                    'school_id' => 'required',
                ],
                [
                    'school_id.required' => 'The School field is required!'
                ]
            );
        } else {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            $this->credentials($request),
            $request->filled('remember')
        );
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {

            return $request->only($this->username(), 'password', 'school_id');
        } else {

            return $request->only('username', 'password', 'school_id');
        }
    }

    /**
     * Send the response after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        return $this->authenticated($request, $this->guard()->user())
            ?: redirect()->intended($this->redirectPath());
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        //
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ]);
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function logout(Request $request)
    // {
    //     $this->guard()->logout();
    //     $request->session()->invalidate();

    //     session_destroy();
    //     session(['role_id' => '']);

    //     return $this->loggedOut($request) ?: redirect('/');
    // }

    /**
     * The user has logged out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        //
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard();
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/after-login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginFormTwo()
    {

        if (Schema::hasTable('users')) {
            if (SmGeneralSettings::isModule('Saas') == TRUE) {
                $schools = SmSchool::orderBy('school_name', 'asc')->get();
                return view('saas::auth.saas_login', compact('schools'));
            } else {
                return view('auth.loginCodeCanyon');
            }
        } else {
            return redirect('install');
        }
    }

    public function loginCodeCanyon()
    {
        if (Schema::hasTable('users')) {
            return view('auth.loginCodeCanyon');
        } else {
            return redirect('install');
        }
    }


    
    //user logout method
    public function logout(Request $request)
    {
        // return $request;
        // if (Auth::user()->role_id == 1) {
        //     $data = SmAcademicYear::where('year', date('Y'))->first();
        //     $selected = SmGeneralSettings::find(1);
        //     $selected->session_id = $data->id;
        //     $selected->session_year = $data->year;
        //     $selected->save();
        // }
        Auth::logout();
        session(['role_id' => '']);
        Session::flush();
        return redirect('/login');
    }
}
