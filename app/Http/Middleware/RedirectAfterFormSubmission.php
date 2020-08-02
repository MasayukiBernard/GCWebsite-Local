<?php

namespace App\Http\Middleware;

use App\CSA_Form;
use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectAfterFormSubmission
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
        if(CSA_Form::where('id', session('csa_form_id'))->first()->is_submitted){
            return redirect(route('student.csa-form.summary'));
        }

        return $next($request);
    }
}
