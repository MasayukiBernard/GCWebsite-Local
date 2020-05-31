<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use PDO;

class EnsureChangePass
{
    // To ensure that user must always use route('student/staff.change-pass-view') before doing a POST
    // for password change. Prevent unauthenticated users to change pass.
    // when this is middleware is used, CSRF middleware must had already been applied
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $prevURL = url()->previous();
        $staffViewRoute = route('staff.change-pass-view');
        $studentViewRoute = route('student.change-pass-view');
        if(Auth::user()->is_staff){
            if($prevURL !== $staffViewRoute){
                return redirect ($staffViewRoute);
            }
        }
        else if (!(Auth::user()->is_staff)){
            if($prevURL !== $studentViewRoute){
                return redirect ($studentViewRoute);    
            }
        }
        return $next($request);
    }
}
