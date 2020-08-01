<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckStudentHasCSAForm
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
        if(session('csa_form_yearly_student_id') == null){
            return redirect(route('student.csa-form.csa-mainpage'));
        }
        
        $student = Auth::user()->student;
        $referred_ys = $student->yearly_students()->where('id', session('csa_form_yearly_student_id'))->first();
        
        // if curr student does not have referred ys record
        if($referred_ys == null){
            session()->put('failed_notif', 'Failed to get the request CSA Application Form');
            return redirect(route('student.csa-form.csa-mainpage'));
        }
        
        // if referred ys doesnt have csa form yet
        if($referred_ys->csa_form == null){
            return redirect(route('student.csa-form.create-page'));
        }

        return $next($request);
    }
}
