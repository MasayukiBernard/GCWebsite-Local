<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStudentHasNoCSAForm
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
        if(session('csa_form_yearly_student_id') == null || session('csa_form_id') != null){
            session()->put('failed_notif', 'Access to create page is not allowed!');
            return redirect(route('student.csa-form.csa-mainpage'));
        }

        return $next($request);
    }
}
