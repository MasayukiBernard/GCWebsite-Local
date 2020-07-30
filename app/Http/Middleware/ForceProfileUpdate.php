<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ForceProfileUpdate
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
            if(is_null($user->latest_updated_at) || is_null($user->student->latest_updated_at)){
                session()->put('warning-notif', 'Please fill your profile completely before accessing other pages on this site!');    
                return redirect(route('student.profile-edit-page'));
            }
        }

        return $next($request);
    }
}
