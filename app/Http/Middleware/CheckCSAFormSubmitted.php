<?php

namespace App\Http\Middleware;

use App\CSA_Form;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckCSAFormSubmitted
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
        $csa_form = CSA_Form::where('id', session('csa_form_id'))->first();

        if(!($csa_form->is_submitted)){
            session('failed_notif', 'Please submit your CSA application form first!');
            return redirect(route('student.csa-form.csa-mainpage'));
        }

        return $next($request);
    }
}
