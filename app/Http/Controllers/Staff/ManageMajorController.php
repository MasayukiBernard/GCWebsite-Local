<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Major;

class ManageMajorController extends Controller{


    private function model_assignment($major, $inputted_data){

        $major->id = $major->id;
        $major->name = $inputted_data['name'];
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

    public function create(){
        $inputted_major = session('inputted_major');
        $major = new Major;
        $this->model_assignment($major , $inputted_major);
        session()->forget(['inputted_major']);
        return redirect('staff_side\master_major\view');

    }
    
    public function update($id){
        $major = Major::find($id);

        $data = [
            'major' => $major,
        ];
        return view('staff_side\master_major\edit', $data);
    }

    public function show_editPage(){
        return view('staff_side\master_major\edit');
    }

    public function delete($id){
        $major = Major::find($id);
        $data = [
            'major' => $major,
        ];
        return view('staff_side\master_major\view', $data);
    }

}