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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    public function redirectTo()
    {
        if(Auth::user()->is_staff){
            return '/staff/home';
        }
        else{
            return '/student/home';
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

        // User logged in using email
        if(filter_var($inputID, FILTER_VALIDATE_EMAIL)){
            if ($this->attemptLogin($request)) {
                return $this->sendLoginResponse($request);
            }
        }
        // User logged in using NIM
        else{
            $studentExist = \App\Student::where('nim', $inputID)->first();
            if($studentExist != null){
            $loggingUser = \App\User::find($studentExist->user_id);
                if(Hash::check($pass, $loggingUser->password)){
                    Auth::login($loggingUser);
                    return $this->sendLoginResponse($request);
                }
            }
        }
    }
}
