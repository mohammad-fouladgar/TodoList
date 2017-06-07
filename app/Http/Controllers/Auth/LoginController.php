<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    use AuthenticatesUsers;

     /**
     * The user must verify your email before login.
     * 
     * @var boolean
     */
    protected $emailConfirmationBeforeLogin = true;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        if ( property_exists($this,'emailConfirmationBeforeLogin') AND 
              $this->emailConfirmationBeforeLogin)
        {
            return $this->loginWithConfirm($request);
        }
        else
        {
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }

            return $this->sendFailedLoginResponse($request);
        }
    }

    /**
     * Login user if verify email address.
     * 
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    private function loginWithConfirm(Request $request)
    {
       if ( ! $this->guard()->once($this->credentials($request))) 
            return $this->sendFailedLoginResponse($request);
                
        if( $this->checkVerificationEmail())
        {
            Auth::login(Auth::getLastAttempted(), $request->has('remember'));

            return $this->sendLoginResponse($request);
        }
        
        return $this->sendFailedLoginVerification($request);
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

        if ($request->expectsJson()) {
            
            return response()->json(['message'=>'Login successfull!','responseURL'=>$this->redirectPath()]);
        }

        return $this->authenticated($request, $this->guard()->user())
                ?: redirect()->intended($this->redirectPath());
    }

    /**
     * check verification email 
     * 
     * @return bool
     */
    private function checkVerificationEmail()
    {
        $user = Auth::getLastAttempted();

        return $user->activated;
    }

    /**
     * Get the failed login verification email instance.
     *
     * @param \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendFailedLoginVerification(Request $request)
    {

        if ($request->expectsJson()) {
            return response()->json(['email'=>'Please activate your account to start using our services!'], 422);
        }

        return redirect()->back()
            ->withInput($request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                'email' => 'Please activate your account to start using our services!',
            ]);
    }
}
