<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use App\Http\Requests\StudentProfileEdit;
use App\Major;
use App\Student_Request;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManageProfileController extends Controller
{
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

    /* Staff Profile */
    public function show_staffProfile(){
        return view('staff_side\profile\view', ['user' => Auth::user()]);
    }

    public function show_staffEditPage(){
        return view('staff_side\profile\edit', ['old_user' => Auth::user()]);
    }

    public function confirm_staffEdit(Request $request){
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
        
        $request->session()->put('staff_validated_profileData', $request->all());
        return view('staff_side\profile\confirm-edit', ['validated_data' => $request]);
    }

    public function update_staff(){
        $curr_user = Auth::user();
        $data = session('staff_validated_profileData');
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

    /* Student Profile */
    public function show_studentProfile(){
        $success = $warning = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        else if(session('warning_notif') != null){
            $warning = session('warning_notif');
        }
        else if (session('failed_notif') != null){
            $failed = session('failed_notif');
        }
        session()->forget(['csa_form_id', 'csa_form_yearly_student_id', 'success_notif', 'warning_notif', 'failed_notif']);

        $user = Auth::user();
        $student_request_id = Student_Request::select('id')
                                ->where('nim', $user->student->nim)
                                ->where('request_type', '1')
                                ->where('is_approved', null)->first();

        $pp_path = Storage::disk('private')->exists($user->student->picture_path);
        $ic_path = Storage::disk('private')->exists($user->student->id_card_picture_path);
        $fc_path = Storage::disk('private')->exists($user->student->flazz_card_picture_path);

        return view('student_side\profile\view', [
            'user' => $user,
            'profile_finalized' => $user->student->is_finalized,
            'email_verified' => $user->email_verified_at == null ? false : true, 
            'request_edit_permission' => $student_request_id == null ? true : false,
            'filemtimes' => [
                'pp' => $pp_path == true ? filemtime(storage_path('app\private\\' . $user->student->picture_path)) : '0',
                'ic' => $ic_path == true ? filemtime(storage_path('app\private\\' . $user->student->id_card_picture_path)) : '0',
                'fc' => $fc_path == true ? filemtime(storage_path('app\private\\' . $user->student->flazz_card_picture_path)) : '0'
            ],
            'success' => $success,
            'warning' => $warning,
            'failed' => $failed
        ]);
    }

    public function show_studentEditPage(){
        $warning = null;
        if(session('warning-notif') != null){
            $warning = session('warning-notif');
            session()->forget('warning-notif');
        }

        $user = Auth::user();
        $pp_path = Storage::disk('private')->exists($user->student->picture_path);
        $ic_path = Storage::disk('private')->exists($user->student->id_card_picture_path);
        $fc_path = Storage::disk('private')->exists($user->student->flazz_card_picture_path);

        return view('student_side\profile\edit', [
            'old_user' => Auth::user(),
            'all_major' => Major::orderBy('name')->get(),
            'filemtimes' => [
                'pp' => $pp_path == true ? filemtime(storage_path('app\private\\' . $user->student->picture_path)) : '0',
                'ic' => $ic_path == true ? filemtime(storage_path('app\private\\' . $user->student->id_card_picture_path)) : '0',
                'fc' => $fc_path == true ? filemtime(storage_path('app\private\\' . $user->student->flazz_card_picture_path)) : '0'
            ],
            'warning' => $warning
        ]);
    }

    public function confirm_studentEdit(StudentProfileEdit $request){
        $validatedData = $request->validated();

        $request->session()->put('student_validated_profileData', Arr::except($validatedData, ['profile-picture', 'id-card', 'flazz-card']));

        $pp = $ic = $fc = null;
        if(Arr::exists($validatedData, 'profile-picture')){
            $pp = Storage::disk('private')->putFile('students/temp/pictures', $validatedData['profile-picture']);
        }
        if (Arr::exists($validatedData, 'id-card')){
            $ic = Storage::disk('private')->putFile('students/temp/national_ids', $validatedData['id-card']);
        }
        if(Arr::exists($validatedData, 'flazz-card')){
            $fc = Storage::disk('private')->putFile('students/temp/ids', $validatedData['flazz-card']);
        }

        $request->session()->put('student_temp_pictures_path', [
            'pp' => $pp,
            'ic' => $ic,
            'fc' => $fc
        ]);

        // to cope with 'date' validation method
        $validatedData['date-birth'] = date('Y-m-d', (new DateTime($validatedData['date-birth']))->getTimeStamp());

        return view('student_side\profile\confirm-edit',[
            'validatedData' => Arr::except($validatedData, ['profile-picture', 'id-card', 'flazz-card']),
            'major' => Major::where('id', $request['major'])->first(),
            'nim' => Auth::user()->student->nim,
        ]);
    }

    public function update_student(){
        $user = Auth::user();
        $text_inputs = session('student_validated_profileData');
        $file_inputs = session('student_temp_pictures_path');
        $file_names = array(
            'pp' => 'students/pictures/',
            'ic' => 'students/national_ids/',
            'fc' => 'students/ids/'
        );

        $user->name = $text_inputs['name'];
        $user->gender = $text_inputs['gender'];

        // Change email verified state when verified email is updated
        if($user->email_verified_at != null && $user->email != $text_inputs['email']){
            $user->email_verified_at = null;
        }
        $user->email = $text_inputs['email'];

        $user->mobile = $text_inputs['mobile'];
        $user->telp_num = $text_inputs['telp-num'];
        $user->student->major_id = $text_inputs['major'];
        $user->student->place_birth = $text_inputs['place-birth'];
        $user->student->date_birth = date('Y-m-d', (new DateTime($text_inputs['date-birth']))->getTimeStamp());
        $user->student->nationality = $text_inputs['nationality'];
        $user->student->address = $text_inputs['address'];

        // Moving stored temp image to the actual image folders
        if($file_inputs['pp'] != null){
            if($user->student->picture_path != '-'){
                if(Storage::disk('private')->exists($user->student->picture_path)){
                    Storage::disk('private')->move($user->student->picture_path, 'students/trashed/pictures/' . Str::afterLast($user->student->picture_path, '/'));
                }
            }
            if((Storage::disk('private')->move($file_inputs['pp'], $file_names['pp'] . Str::afterLast($file_inputs['pp'], '/'))) == true){
                $user->student->picture_path = $file_names['pp'] . Str::afterLast($file_inputs['pp'], '/');
            }
        }
        if ($file_inputs['ic'] != null){
            if($user->student->id_card_picture_path != '-'){
                if(Storage::disk('private')->exists($user->student->id_card_picture_path)){
                    Storage::disk('private')->move($user->student->id_card_picture_path, 'students/trashed/national_ids/' . Str::afterLast($user->student->id_card_picture_path, '/'));
                }
            }
            if((Storage::disk('private')->move($file_inputs['ic'], $file_names['ic'] . Str::afterLast($file_inputs['ic'], '/'))) == true){
                $user->student->id_card_picture_path = $file_names['ic'] . Str::afterLast($file_inputs['ic'], '/');
            }
        }
        if ($file_inputs['fc'] != null){
            if($user->student->flazz_card_picture_path != '-'){
                if(Storage::disk('private')->exists($user->student->flazz_card_picture_path)){
                    Storage::disk('private')->move($user->student->flazz_card_picture_path, 'students/trashed/ids/' . Str::afterLast($user->student->flazz_card_picture_path, '/'));
                }
            }
            if((Storage::disk('private')->move($file_inputs['fc'], $file_names['fc'] . Str::afterLast($file_inputs['fc'], '/'))) == true){
                $user->student->flazz_card_picture_path = $file_names['fc'] . Str::afterLast($file_inputs['fc'], '/');
            }
        }
        $user->student->save();
        $user->save();
        session()->put('success_notif', 'You have successfuly edited your profile info!');

        session()->forget(['student_validated_profileData', 'student_temp_pictures_path']);

        return redirect(route('student.profile'));
    }

    public function finalize_profile(){
        $student = Auth::user()->student;
        if(!$student->is_finalized){
            $student->is_finalized = true;
            $student->save();
            session()->put('success_notif', 'You have successfuly finalized your profile!');
        }
        
        return redirect(route('student.profile'));
    }

    public function show_requestProfileEditPage(){
        return view('student_side\profile\request-edit');
    }

    public function request_profile_edit(Request $request){
        $validatedData = $request->validate([
            'description' => ['required', 'string']
        ]);

        $student_request = new Student_Request();
        $student_request->nim = Auth::user()->student->nim;
        $student_request->request_type = '1';
        $student_request->description = $validatedData['description'];
        $student_request->latest_updated_at = null;
        $student_request->save();

        session()->put('success_notif', 'You have successfuly made a \'Profile Edit Request\' it will be notified to the staffs, please wait for their approval!');
        return redirect(route('student.profile'));
    }
}
