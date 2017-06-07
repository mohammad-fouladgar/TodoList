<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = 'dashboard';

    /**
     * The user must verify your email before login.
     * 
     * @var boolean
     */
    protected $emailConfirmationBeforeLogin = true;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

         \DB::beginTransaction();
        try{
            $user = $this->create($request->all());

            $eventConstruct = [
                    'user' =>[
                        'email'    => $user->email,
                        'fullname' => $user->name,
                        'token'    => $user->token
                    ]
                ];

            if ( ! property_exists($this,'emailConfirmationBeforeLogin') OR 
                    ! $this->emailConfirmationBeforeLogin)
            {
                $this->guard()->login($user);
            }

            event(new Registered($eventConstruct));

         } catch (\Exception $ex) { \DB::rollback(); throw $ex; }
          \DB::commit();

          return response()->json([
            'message'     =>'Your account has been created successfully! Please Check Your e-mail and try again to login.',
            'responseURL' => $this->redirectPath()
        ]);

    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($token)
    {
        User::whereToken($token)->firstOrFail()->confirmEmail();

        return redirect()->route('login')->with('flash_message','You are now activated!');
    }


}
