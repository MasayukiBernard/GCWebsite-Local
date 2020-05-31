<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsStaff
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
        // if current authenticated user is not a staff
        if(!(Auth::user()->is_staff)){
            abort(403, 'You are unauthorized!!');
        }
        return $next($request);
    }
}
