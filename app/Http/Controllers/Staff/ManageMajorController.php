<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Major;
use App\Http\Requests\MajorCRUD;

class ManageMajorController extends Controller{


    private function model_assignment($major, $inputted_data){
        $major->id = $major->id;
        $major->name = $inputted_data['major-name'];
        $major->save();
    }

    public function show_majorpage(){
        $success = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        session()->forget('success_notif');

        $major = Major::orderBy('name')->get();
        $data =[
            'majors' => $major,
            'success' => $success,
        ];

        return view('staff_side\master_major\view', $data );
    }

    public function show_createPage(){
        return view('staff_side\master_major\create');
    }

    public function confirm_create(MajorCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        session()->forget(['inputted_major']);
        $request->session()->put('inputted_major', $validatedData);

        return view('staff_side/master_major/create-confirm', ['inputted_major' => $validatedData]);
    }

    public function create(){
        $inputted_major = session('inputted_major');
        $major = new Major;
        $this->model_assignment($major, $inputted_major);
        session()->forget(['inputted_major']);

        session()->put('success_notif', 'You have successfuly CREATED 1 new major record!');
        return redirect(route('staff.major.page'));
    }

    public function show_editPage(Major $major){
        session()->forget('referred_major_id');
        session()->put('referred_major_id', $major->id);

        return view('staff_side\master_major\edit', ['referred_major' => $major]);
    }
    
    public function confirm_update(MajorCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        session()->forget(['inputted_major']);
        $request->session()->put('inputted_major', $validatedData);

        session()->put('success_notif', 'You have successfuly UPDATED 1 new major record!');
        return view('staff_side/master_major/update-confirm', ['referred_major' => Major::find(session('referred_major_id')), 'inputted_major' => $validatedData]);
    }

    public function update(){
        $inputted_major = session('inputted_major');
        $major = Major::where('id', session('referred_major_id'))->first();
        
        if($major != null){
            $this->model_assignment($major, $inputted_major);
            session()->forget(['inputted_major', 'referred_major_id']);
        }

        // Feedback
        return redirect(route('staff.major.page'));
    }

    public function confirm_delete($major_id){
        $major = Major::where('id', $major_id)->first();
        if($major != null){
            session()->put('referred_major_id', $major->id);
            return response()->json([
                'referred_major' => $major,
                'failed' => false
            ]);
        } 
        else{
            return response()->json(['failed' => true]);
        }
    }

    public function delete(){
        $major = Major::find(session('referred_major_id'));
        $major->delete();
        session()->forget('referred_major_id');
        
        session()->put('success_notif', 'You have successfuly DELETED 1 major record!');
        return redirect(route('staff.major.page'));
    }

}