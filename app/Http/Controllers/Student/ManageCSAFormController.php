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
use App\Http\Requests\StudentCSAFormCreate;
use App\User;
use App\Student;
use App\Personal_Information;
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
        return view('student_side\csa_form\csa-page1',[
            'user' => $user,
            'user_student' => $student
        ]);
    }

    public function page1_insert(){
        return redirect(route('student_side\csa_form\csa-page2'));
    }

    public function insertPage2(){
        return view('student_side\csa_form\csa-page2');
    }
    public function postInsertPage2(){
        return redirect(route('student_side\csa_form\csa-page3'));
    }

    public function insertPage3(){
        return view('student_side\csa_form\csa-page3');
    }
    public function postInsertPage3(){
        return redirect(route('student_side\csa_form\csa-page4'));
    }

    public function insertPage4(){
        return view('student_side\csa_form\csa-page4');
    }
    public function postInsertPage4(){
        return redirect(route('student_side\csa_form\csa-page5'));
    }

    public function insertPage5(){
        return view('student_side\csa_form\csa-page5');
    }
    public function postInsertPage5(){
        return redirect(route('student_side\csa_form\csa-page6'));
    }

    public function insertPage6(){
        return view('student_side\csa_form\csa-page6');
    }
    public function postInsertPage6(){
        return redirect(route('student_side\csa_form\csa-page7'));
    }

    public function insertPage7(){
        return view('student_side\csa_form\csa-page7');
    }
    public function postInsertPage7(){
    }

}
