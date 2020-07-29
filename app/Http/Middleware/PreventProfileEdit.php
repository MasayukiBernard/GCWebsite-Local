<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class PreventProfileEdit
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
            if($user->student->is_finalized){
                session()->put('failed_notif', 'You are not allowed to edit your profile information, please make a request to edit your profile!');
                return redirect(route('student.profile'));
            }
        }

        return $next($request);
    }
}
