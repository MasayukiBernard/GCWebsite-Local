<?php

namespace App\Http\Controllers\User;

use App\Academic_Year;
use App\Http\Controllers\Controller;
use App\Notifications\CSAFormCreated;
use App\Notifications\CSAFormSubmitted;
use Illuminate\Support\Facades\Auth;

class ManageCSAFormController extends Controller
{
    public function show_csaFormPage(){
        return view('student_side\csaform');
    }

    public function mail_tempCreatedCSAForm(){
        Auth::user()->notify(new CSAFormCreated(Auth::user()->student->yearly_students()->first()->academic_year));
    }

    public function mail_tempSubmittedCSAForm(){
        Auth::user()->notify(new CSAFormSubmitted(Auth::user()->student->yearly_students()->first()->academic_year));
    }
}
