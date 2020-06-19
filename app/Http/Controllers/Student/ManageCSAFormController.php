<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class ManageCSAFormController extends Controller
{
    public function show_csaFormPage(){
        return view('student_side\csaform');
    }
}
