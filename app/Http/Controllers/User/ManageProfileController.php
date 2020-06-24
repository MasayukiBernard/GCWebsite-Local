<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ManageProfileController extends Controller
{
    public function show_studentProfile(){
        return view('student_side\profile');
    }

    public function show_staffProfile(){
        return view('staff_side\profile');
    }

    public function show_changePass(){
        return view('profile_management\change-pass');
    }

    // Using "Form Request" validator
    // The strings are not trimmed using the TrimString middleware exception
    public function handle_ChangePass(ChangePassword $request){
        $validatedData = $request->validated();
        $currUser = Auth::user();
        $currUser->password = Hash::make($validatedData['confirm-new-pass']);
        $currUser->save();
        // Reset password confirmation timer
        $request->session()->put('auth.password_confirmed_at', 0);
        return redirect(Auth::user()->is_staff ? route('staff.home') : route('student.home'));
    }
}
