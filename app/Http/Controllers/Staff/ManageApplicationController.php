<?php

namespace App\Http\Controllers\Staff;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageApplicationController extends Controller{

    public function show_applicationPage(){
        return view('staff_side/application');
    }
}