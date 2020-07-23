<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Achievement;
use App\Academic_Info;
use App\Choice;
use App\Condition;
use App\CSA_Form;
use App\Emergency;
use App\English_Test;
use App\Major;
use App\Http\Requests\StudentCSAFormCreate;
use App\User;
use App\Student;
use App\Personal_Information;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function show_insertPage1(){
        // Entry point to CSA Form
        // $csa_form = new CSA_Form();
        // $csa_form->yearly_student_id = xxxx;
        // $csa_form->save();
        // Notify student by email 

        $user = Auth::user();
        $student = $user->student;
        $nim = $student->nim;
        $yearly_student_id = DB::table('yearly_students')->select('id')->where('nim', $nim);
        $csa_id = DB::table('csa_forms')->select('id')->where('yearly_student_id', $yearly_student_id);
        return view('student_side\csa_form\csa-page1',[
            'csa_id' =>$csa_id,
            'user' => $user,
            'user_student' => $student
        ]);
    }

    public function page1_insert(){
        return redirect(route('student_side\csa_form\csa-page2', $csa_id));
    }

    public function insertPage2($csa_id){
        $major = Major::All();
        $test = English_Test::All();
        $academic_info = Academic_Info::where('csa_form_id', $csa_id)->first();
        $english_test = English_Test::where('csa_form_id', $csa_id)->first();
        $major_id = $academic_info->major_id;
        $major_name = DB::table('majors')->select('name')->where('id', $major_id);
        return view('student_side\csa_form\csa-page2', [
            'csa_id' =>$csa_id,
            'english_test' =>$english_test,
            'major_name' => $major_name,
            'academic_info' => $academic_info,
            'majors' => $major,
            'testtype' => $test
        ]);
    }
    public function postInsertPage2(Request $request){
        $academic_info = Academic_Info::where('csa_form_id', $csa_id)->first();
        $english_test = English_Test::where('csa_form_id', $csa_id)->first();

        $academic_info->campus = $request->campus;
        $academic_info->study_level = $request->study_level;
        $academic_info->class = $request->class;
        $academic_info->semester = $request->semester;
        $academic_info->gpa = $request->gpa;

        $english_test->test_type = $request->test_type;
        $english_test->score = $request->score;
        $english_test->test_date = $request->date;

        $academic_info->save();
        $english_test->save();

        return redirect(route('student_side\csa_form\csa-page3', $csa_id));
    }

    public function insertPage3($csa_id){
        return view('student_side\csa_form\csa-page3', [
            'csa_id' => $csa_id,
        ]);
    }
    public function postInsertPage3(){
        return redirect(route('student_side\csa_form\csa-page4', $csa_id));
    }

    public function insertPage4($csa_id){
        return view('student_side\csa_form\csa-page4', [
            'csa_id' => $csa_id,
        ]);
    }
    public function postInsertPage4(){
        return redirect(route('student_side\csa_form\csa-page5', $csa_id));
    }

    public function insertPage5($csa_id){
        return view('student_side\csa_form\csa-page5', [
            'csa_id' => $csa_id,
        ]);
    }
    public function postInsertPage5(){
        return redirect(route('student_side\csa_form\csa-page6', $csa_id));
    }

    public function insertPage6($csa_id){
        return view('student_side\csa_form\csa-page6', [
            'csa_id' => $csa_id,
        ]);
    }
    public function postInsertPage6(){
        return redirect(route('student_side\csa_form\csa-page7', $csa_id));
    }

    public function insertPage7($csa_id){
        return view('student_side\csa_form\csa-page7', [
            'csa_id' => $csa_id,
        ]);
    }
    public function postInsertPage7(){
    }

}
