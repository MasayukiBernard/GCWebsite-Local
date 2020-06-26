<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Major;
use App\Http\Requests\MajorCRUD;

class ManageMajorController extends Controller{


    private function model_assignment($major, $inputted_data){

        $major->id = $major->id;
        $major->name = $inputted_data['major-name'];
        $major->save();
    }

    public function show_majorpage(){
        $major = Major::All();
        $data =[
            'majors' => $major
        ];
        return view('staff_side\master_major\view', $data );
    }

    public function show_createPage(){
        return view('staff_side\master_major\create');
    }

    public function confirm_create(MajorCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        $request->session()->put('inputted_major', $validatedData);
        return view('staff_side/master_major/create-confirm', ['inputted_major' => $validatedData]);
    }

    public function create(){
        $inputted_major = session('inputted_major');
        $major = new Major;
        $this->model_assignment($major , $inputted_major);
        session()->forget(['inputted_major']);
        return redirect(route('staff.major.page'));

    }
    
    public function confirm_update(MajorCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        $request->session()->put('inputted_major', $validatedData);
        return view('staff_side/master_major/update-confirm', ['referred_major' => Major::find(session('referred_major_id')), 'inputted_major' => $validatedData]);
    }

    public function update(){
        $inputted_major = session('inputted_major');
        $major = Major::where('id', session('referred_major_id'))->first();
        
        if($major != null){
            $this->model_assignment($major, $inputted_major);
            session()->forget(['inputted_major', 'referred_major_id']);
        }
        return redirect(route('staff.major.page'));
    }

    public function show_editPage(Major $major){
        Session()->put('referred_major_id', $major->id);
        return view('staff_side\master_major\edit', ['referred_major' => $major]);
    }

    public function confirm_delete($major_id){
        $major = Major::where('id', $major_id)->first();
        if($major != null){
            session()->put('referred_major_id', $major->id);
            return response()->json(['referred_major' => $major]);
        }
        else{
            return response()->json(['failed' => true]);
        }
    }

    public function delete(){
        $major = Major::find(session('referred_major_id'));
        $major->delete();
        session()->forget('referred_major_id');
        return redirect(route('staff.major.page'));
    }

}