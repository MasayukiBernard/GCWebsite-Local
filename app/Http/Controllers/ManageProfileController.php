<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ManageProfileController extends Controller
{
    public function show_studentProfile(){
        return view('student_side\profile');
    }

    public function show_staffProfile(){
        return view('staff_side\profile\view', ['user' => Auth::user()]);
    }

    public function show_editPage(){
        return view('staff_side\profile\edit', ['old_user' => Auth::user()]);
    }

    public function confirm_edit(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:75'],
            'email' => ['required', 'email:rfc', 'max:50'],
            'position' => ['required', 'string', 'max:50'],
            'gender' => ['required', 'in:M,F', 'max:1'],
            'mobile' => ['required', 'digits_between:1,13'],
            'telp-num' => ['required', 'digits_between:1,14'],
        ],[],[
            'mobile' => 'mobile phone number',
            'telp-num' => 'telephone number'
        ]);

        if ($validator->fails()) {
            return redirect(route('staff.profile-edit-page'))
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $request->session()->put('validated_data', $request->all());
        return view('staff_side\profile\confirm-edit', ['validated_data' => $request]);
    }

    public function update(){
        Log::info('where');
        $curr_user = Auth::user();
        $data = session('validated_data');
        $curr_user->name = $data['name'];
        $curr_user->email = $data['email'];
        $curr_user->gender = $data['gender'];
        $curr_user->mobile = $data['mobile'];
        $curr_user->telp_num = $data['telp-num'];
        $curr_user->save();
        $curr_user->staff->position = $data['position'];
        $curr_user->staff->save();

        return redirect(route('staff.profile'));
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
