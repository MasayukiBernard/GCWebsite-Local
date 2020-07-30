<?php

namespace App\Http\Middleware;

use App\Student_Request;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NoProfileEditRequest
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
            $student_request_id = Student_Request::select('id')
                                    ->where('nim', $user->student->nim)
                                    ->where('request_type', '1')
                                    ->where('is_approved', null)->first();
            if($student_request_id != null){
                session()->put('warning_notif', 'Please wait for your profile edit request feedback before accessing other pages on this site!');    
                return redirect(route('student.profile-edit-page'));
            }
        }

        return $next($request);
    }
}
