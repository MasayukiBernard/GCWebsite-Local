<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;

class ManageApplicationController extends Controller
{
    public function show_applicationPage(){
        return view('staff_side\application');
    }
    
}
