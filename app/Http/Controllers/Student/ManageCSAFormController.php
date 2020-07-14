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
use App\User;
use App\Student;
use App\Personal_Information;

class ManageCSAFormController extends Controller
{
    // public function show_csaFormPage(){
    //     return view('student_side\csa_form\csa-page1');
    // }

    public function insertPage1(Request $request){
        $personal_information = $request->session()->get('personal_information');
        return view('student_side\csa_form\csa-page1', compact('personal_information'));
    }
    public function postInsertPage1(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'nim' => 'required',
            'picture_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'required',
            'place_birth' => 'required',
            'date_birth' => 'required',
            'nationality' => 'required',
            'email' => 'required',
            'mobile' => 'required',
            'telp_num' => 'required',
            'address' => 'required',
            'flazz_card_picture_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'id_card_picture_path' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048', 
        ]);
        if(empty($request->session()->get('personal_information'))){
            $personal_information = new \App\Personal_Information();
            $personal_information->fill($validatedData);
            $personal_information->session()->put('personal_information', $personal_information);
        }else{
            $personal_information = $request->session()->get('personal_information');
            $personal_information->fill($validatedData);
            $personal_information->session()->put('personal_information', $personal_information);
        }
        return redirect('student_side\csa_form\csa-page2');
    }

    public function insertPage2(){

    }
    public function postInsertPage2(){
        
    }

    public function insertPage3(){

    }
    public function postInsertPage3(){
        
    }

    public function insertPage4(){

    }
    public function postInsertPage4(){
        
    }

    public function insertPage5(){

    }
    public function postInsertPage5(){
        
    }

    public function insertPage6(){

    }
    public function postInsertPage6(){
        
    }

    public function insertPage7(){

    }
    public function postInsertPage7(){
        
    }

}
