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
use App\Http\Requests\StudentCSAFormCreate;
use App\User;
use App\Student;
use App\Personal_Information;
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
        session()->forget('csa_form_yearly_student_id');
        return view('student_side\csa_form\csa-mainpage', ['academic_years' =>Academic_Year::whereIn('id', Arr::pluck($academic_year_id, 'academic_year_id'))->orderBy('ending_year', 'desc')->orderBy('odd_semester')->get()]);
    }

    public function afterInitial_view($academic_year_id){
        $yearly_student_id = Auth::user()->student->yearly_students()->where('academic_year_id', $academic_year_id)->first()->id;
        session()->put('csa_form_yearly_student_id', $yearly_student_id);
        if($academic_year_id == null){
            abort(404);
        }
        else{
            return redirect(route('student.csa_form.csa-page1'));
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
        
        return view('student_side\csa_form\csa-page1',[
            'user' => $user,
            'user_student' => $student
        ]);
    }

    public function page1_insert(){
        return redirect(route('student_side\csa_form\csa-page2', $csa_id));
    }

    public function insertPage2(){
        $major = Major::All();
        $test = English_Test::All();
        
        return view('student_side\csa_form\csa-page2', [   
         
            'majors' => $major,
            'testtype' => $test
        ]);
    }
    public function afterInsertPage2(Request $request){
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

    public function insertPage3(){
        return view('student_side\csa_form\csa-page3', [
        ]);
    }
    public function afterInsertPage3(){
        return redirect(route('student_side\csa_form\csa-page4', $csa_id));
    }

    public function insertPage4(){
        return view('student_side\csa_form\csa-page4', [
        ]);
    }
    public function afterInsertPage4(){
        return redirect(route('student_side\csa_form\csa-page5', $csa_id));
    }

    public function insertPage5(){
        return view('student_side\csa_form\csa-page5', [
        ]);
    }
    public function afterInsertPage5(){
        return redirect(route('student_side\csa_form\csa-page6', $csa_id));
    }

    public function insertPage6(){
        return view('student_side\csa_form\csa-page6', [
        ]);
    }
    public function afterInsertPage6(){
        return redirect(route('student_side\csa_form\csa-page7', $csa_id));
    }

    public function insertPage7(){
        return view('student_side\csa_form\csa-page7', [
        ]);
    }
    public function afterInsertPage7(){
    }

}
