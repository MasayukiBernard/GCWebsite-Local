<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Major;

class ManageMajorController extends Controller{


    private function create_new_major($name){

        $major = new Major();
        $major->id = $major->id;
        $major->name = $name;
        $major->save();
    }

    public function show_majorpage(){
        $major = Major::All();
        $data =[
            'majors' => $major
        ];
        return view('staff_side\master_major\view', $data);
    }

    public function show_createPage(){
        return view('staff_side\master_major\create');
    }

}