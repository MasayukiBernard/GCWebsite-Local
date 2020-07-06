<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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

    private $maxAttempts = 3;
    private $decayMinutes = 15;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        if(Auth::user()->is_staff){
            return route('staff.home');
        }
        else{
            return route('student.home');
        }
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // If user is already authenticated, then redirect to 'HOME'
        $this->middleware('guest')->except('logout');
    }
    
    // Still needs to be refined    
    public function login(Request $request)
    {
        $inputID = $request->email;
        $pass = $request->password;

        $this->validateLogin($request);

        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if(filter_var($inputID, FILTER_VALIDATE_EMAIL)){
            // User logged in using email
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        }
        else{
            // User logged in using NIM
            $student = \App\Student::where('nim', $inputID)->first();
            if($student != null){
                $loggingUser = \App\User::find($student->user_id);
                if(Hash::check($pass, $loggingUser->password)){
                    Auth::login($loggingUser, $request->filled('remember'));
                    return $this->sendLoginResponse($request);
                }
            }
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
}
