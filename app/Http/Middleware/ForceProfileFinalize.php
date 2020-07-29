<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceProfileFinalize
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        
        if(!($user->is_staff)){
            if(!($user->student->is_finalized)){
                session()->put('warning_notif', 'Please finalize your profile before visiting other pages in this site!');
                return redirect(route('student.profile'));
            }
        }

        return $next($request);
    }
}
