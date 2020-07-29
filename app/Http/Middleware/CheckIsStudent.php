<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

// Might not be used, delete later
class CheckIsStudent
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
        // if current authenticated user is not a student
        if(Auth::user()->is_staff){
            return redirect(route('staff.home'));
        }

        return $next($request);
    }
}
