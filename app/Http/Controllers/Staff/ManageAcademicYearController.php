<?php

namespace App\Http\Controllers\Staff;

use App\Academic_Year;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearCRUD;

class ManageAcademicYearController extends Controller
{
    public function show_academicYearPage(){
        return view('staff_side/academic_year/view', ['academic_years' => Academic_Year::orderBy('starting_year')->orderBy('odd_semester', 'desc')->get()]);
    }
    
    public function show_createPage(){
        $latest_year = Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->first();
        $temp_year = new Academic_Year();
        if($latest_year == null){
            $temp_year->starting_year = date('Y', time());
            $temp_year->ending_year = $temp_year->starting_year + 1;
            $temp_year->odd_semester = true;
        }
        else{
            if($latest_year->odd_semester){
                $temp_year->starting_year = $latest_year->starting_year;
                $temp_year->ending_year = $latest_year->ending_year;
                $temp_year->odd_semester = false;
            }
            else{
                $temp_year->starting_year = $latest_year->starting_year + 1;
                $temp_year->ending_year = $latest_year->ending_year + 1;
                $temp_year->odd_semester = true;
            }
        }
        return view('staff_side/academic_year/create', ['temp_year' => $temp_year]);
    }

    public function confirm_create(AcademicYearCRUD $request){
        $request->flash();
        $validatedData = $request->validated();
        $request->session()->put('inputted_academic_year', $validatedData);
        return view('staff_side/academic_year/confirm-create', ['inputtedData' => $validatedData]);
    }

    public function create(){
        $academic_year = new Academic_Year();
        $academic_year->starting_year = session('inputted_academic_year')['start-year'];
        $academic_year->ending_year = session('inputted_academic_year')['end-year'];
        $academic_year->odd_semester = session('inputted_academic_year')['smt-type'];
        $academic_year->save();
        session()->forget('inputted_academic_year');
        return redirect(route('staff.academic-year.page'));
    }

    public function confirm_delete($academic_year_id){
        $academic_year = Academic_Year::where('id', $academic_year_id)->first();
        if($academic_year != null){
            session()->put('reffered_academic_year_id', $academic_year->id);
            return response()->json(['reffered_academic_year' => $academic_year]);
        }
        else{
            return response()->json(['failed' => true]);
        }
    }

    public function delete(){
        $academic_year = Academic_Year::find(session('reffered_academic_year_id'));
        $academic_year->delete();
        session()->forget('reffered_academic_year_id');
        return redirect(route('staff.academic-year.page'));
    }
}