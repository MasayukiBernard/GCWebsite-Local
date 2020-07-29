<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Achievement;
use App\Academic_Info;
use App\Academic_Year;
use App\Choice;
use App\Condition;
use App\CSA_Form;
use App\Emergency;
use App\English_Test;
use App\Major;
use App\Passport;
use App\Http\Requests\StudentCSAFormCreate;
use App\User;
use App\Student;
use App\Partner;
use App\Yearly_Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\Store;

class ManageCSAFormController extends Controller
{
    /*
        Rules for Profile Page:
        'name' => ['required'],
        'nim' => ['required'],
        'picture_path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        'gender' => ['required'],
        'place_birth' => ['required'],
        'date_birth' => ['required'],
        'nationality' => ['required'],
        'email' => ['required'],
        'mobile' => ['required'],
        'telp_num' => ['required'],
        'address' => ['required'],
        'flazz_card_picture_path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        'id_card_picture_path' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
    */

    // public function show_csaFormPage(){
    //     return view('student_side\csa_form\csa-page1');
    // }

    public function initial_view(){
        $user = Auth::user();
        $student = $user->student;
        $nim = $student->nim;
        $academic_year_id = DB::table('yearly_students')->select('academic_year_id')->where('nim', $nim)->get();
        session()->forget('csa_form_id');
        session()->forget('csa_form_yearly_student_id');
        return view('student_side\csa-form\csa-mainpage', ['academic_years' =>Academic_Year::whereIn('id', Arr::pluck($academic_year_id, 'academic_year_id'))->orderBy('ending_year', 'desc')->orderBy('odd_semester')->get()]);
    }

    public function afterInitial_view($academic_year_id){
        $yearly_student_id = Auth::user()->student->yearly_students()->where('academic_year_id', $academic_year_id)->first()->id;
        if($yearly_student_id == null){
            abort(404);
        }
        else{
            session()->put('csa_form_yearly_student_id', $yearly_student_id);
            return redirect(route('student.csa-form.csa-page1'));
        }
    }

    public function show_insertPage1(){
        // Entry point to CSA Form
        // $csa_form = new CSA_Form();
        // $csa_form->yearly_student_id = xxxx;
        // $csa_form->save();
        // Notify student by email 

        $user = Auth::user();
        $student = $user->student;
        $nim = $student->nim;
        return view('student_side\csa-form\csa-page1',[
            'user' => $user,
            'user_student' => $student
        ]);
    }

    public function page1_insert(){

        $csa_form = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first();
        if($csa_form == null){
            $csa_form = new CSA_Form;
            $csa_form->id = $csa_form->id;
            $csa_form->yearly_student_id = session('csa_form_yearly_student_id');
            $csa_form->is_submitted = false;
            $csa_form->save();
            return redirect(route('student.csa-form.csa-page2'));
        }
        else{
            return redirect(route('student.csa-form.csa-page2'));
        }
    }

    public function insertPage2(){
        $csa_id = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first()->id;
        session()->put('csa_form_id', $csa_id);
        $majors = Major::All();
        $test = English_Test::All();
        $academic_info = Academic_Info::where('csa_form_id', session('csa_form_id'))->first();
        $english_test = English_Test::where('csa_form_id', session('csa_form_id'))->first();
        $passport = Passport::where('csa_form_id', session('csa_form_id'))->first();
        if($academic_info == null && $english_test == null && $passport == null){
            return view('student_side\csa-form\csa-page2', [ 
            'english_test' => new English_Test(),
            'passport' => new Passport(),
            'academic_info'=> new Academic_Info(),
            'majors' => $majors,
            'testtype' => $test,
            ]);
        }
        else{
            return view('student_side\csa-form\csa-page2', [   
                'english_test' => $english_test,
                'passport' => $passport,
                'academic_info'=>$academic_info,
                'majors' => $majors,
                'testtype' => $test
            ]);
        }
    }

    public function afterInsertPage2(Request $request){
        $academic_info = Academic_Info::where('csa_form_id', session('csa_form_id'))->first();
        $english_test = English_Test::where('csa_form_id', session('csa_form_id'))->first();
        $passport = Passport::where('csa_form_id', session('csa_form_id'))->first();
        if($academic_info == null || $english_test == null || $passport == null)
        {
            $academic_info = new Academic_Info();
            $academic_info->csa_form_id = session('csa_form_id');
            $academic_info->major_id = $request->major;
            $academic_info->campus = $request->campus;
            $academic_info->study_level = 'U';
            $academic_info->class = 'Global Class';
            $academic_info->semester = $request->semester;
            $academic_info->gpa = $request->gpa;
            $academic_info->gpa_proof_path = 'students\gpa_transcripts\dummy_gpa.png';

            $english_test = new English_Test();
            $english_test->csa_form_id = session('csa_form_id');
            $english_test->test_type = $request->test_type;
            $english_test->score = $request->score;
            $english_test->test_date = $request->date;
            $english_test->proof_path = 'students\english_tests\TOEFL/dummy_toefl.jpg';

            $passport = new Passport();
            $passport->csa_form_id = session('csa_form_id');
            $passport->pass_num = $request->pass_num;
            $passport->pass_expiry = $request->pass_expiry;
            $passport->pass_proof_path = 'students\passports\dummy_passport.jpeg';
        }
        
        else{
            $academic_info->campus = $request->campus;
            $academic_info->study_level = 'U';
            $academic_info->class = 'Global Class';
            $academic_info->semester = $request->semester;
            $academic_info->gpa = $request->gpa;
            $academic_info->gpa_proof_path = 'students\gpa_transcripts\dummy_gpa.png';

            $english_test->test_type = $request->test_type;
            $english_test->score = $request->score;
            $english_test->test_date = $request->date;
            $english_test->proof_path = 'students\english_tests\TOEFL/dummy_toefl.jpg';

            $passport->pass_num = $request->pass_num;
            $passport->pass_expiry = $request->pass_expiry;
            $passport->pass_proof_path = 'students\passports\dummy_passport.jpeg';
        }

        $academic_info->save();
        $english_test->save();
        $passport->save();

        return redirect(route('student.csa-form.csa-page3'));
    }

    public function insertPage3(){
        $achievement = Achievement::where('csa_form_id', session('csa_form_id'))->get();
        if($achievement==null){
            return view('student_side\csa-form\csa-page3', [
                'achievement' => new Achievement(),
            ]);   
        }
        else{
            $achievement_name = Achievement::select('achievement')->where('csa_form_id', session('csa_form_id'))->get();
            return view('student_side\csa-form\csa-page3', [
                'achievement_name' => $achievement_name,
            ]);
        }
        
    }
    public function afterInsertPage3(){
        return redirect(route('student.csa-form.csa-page4'));
    }

    public function insertPage4(){
        $user = Auth::user();
        $student = $user->student;
        $major_id = $student->major_id;
        $partner = Partner::where('major_id', $major_id)->get();
        $choice = Choice::where('csa_form_id', session('csa_form_id'))->get();
        if($choice == null){
            return view('student_side\csa-form\csa-page4', [
            'choice' => new Choice(),
            'partner'=>$partner,
            ]);
        }
        else{
            return view('student_side\csa-form\csa-page4', [
                'partner'=>$partner,
            ]);
        }
    }

    public function afterInsertPage4(){
        return redirect(route('student.csa-form.csa-page5'));
    }

    public function insertPage5(){
        $emergency = Emergency::where('csa_form_id', session('csa_form_id'))->first();
        if($emergency == null){
            return view('student_side\csa-form\csa-page5', [
                'emergency' => new Emergency(),
            ]);
        }
        else
        {
            return view('student_side\csa-form\csa-page5', [
                'emergency' => $emergency,
            ]);
        }
    }
    public function afterInsertPage5(Request $request){
        $emergency = Emergency::where('csa_form_id', session('csa_form_id'))->first();
        if($emergency == null){
            $emergency = new Emergency();
            $emergency->csa_form_id = session('csa_form_id');
            $emergency->name = $request->name;
            $emergency->gender = 'F';
            $emergency->relationship = $request->relationship;
            $emergency->address = $request->address;
            $emergency->mobile = $request->mobilenum;
            $emergency->telp_num = $request->telp_num;
            $emergency->email = $request->email;

        }
        else{
            $emergency->name = $request->name;
            $emergency->relationship = $request->relationship;
            $emergency->address = $request->address;
            $emergency->mobile = $request->mobilenum;
            $emergency->telp_num = $request->telp_num;
            $emergency->email = $request->email;
        }

        $emergency->save();

        return redirect(route('student.csa-form.csa-page6'));
    }

    public function insertPage6(){
        $condition = Condition::where('csa_form_id', session('csa_form_id'))->first();
        if($condition == null){
            return view('student_side\csa-form\csa-page6', [
                'condition' => new Condition(),
            ]);
        }
        else{
            return view('student_side\csa-form\csa-page6', [
                'condition' => $condition,
            ]);
        }
    }
    public function afterInsertPage6(Request $request){
        $condition = Condition::where('csa_form_id', session('csa_form_id'))->first();
        if($condition == null){
            $condition = new Condition();
            $condition->csa_form_id = session('csa_form_id');
            $condition->med_condition = $request->med_condition;
            $condition->allergy = $request->allergy;
            $condition->special_diet = $request->special_diet;
            $condition->convicted_crime = $request->convicted_crime;
            $condition->future_diffs = $request->future_diffs;
            $condition->reasons = $request->explanation;
        }
        else{
            $condition->med_condition = $request->med_condition;
            $condition->allergy = $request->allergy;
            $condition->special_diet = $request->special_diet;
            $condition->convicted_crime = $request->convicted_crime;
            $condition->future_diffs = $request->future_diffs;
            $condition->reasons = $request->explanation;
        }

        $condition->save();

        return redirect(route('student.csa-form.csa-page7'));
    }

    public function insertPage7(){
        return view('student_side\csa-form\csa-page7', [
        ]);
    }
    public function afterInsertPage7(){
        $csa_form = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first();
        $csa_form->is_submitted = true ;
        $csa_form->save();
        return redirect(route('student.home'));
    }

}
