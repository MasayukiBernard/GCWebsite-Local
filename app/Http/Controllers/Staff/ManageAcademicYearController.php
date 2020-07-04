<?php

namespace App\Http\Controllers\Staff;

use App\Academic_Year;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicYearCRUD;

class ManageAcademicYearController extends Controller
{
    public function show_academicYearPage(){
        $success = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        session()->forget('success_notif');

        return view('staff_side/academic_year/view', [
            'academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get(),
            'success' => $success,
        ]);
    }
    
    public function show_createPage(){
        $latest_year = Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->first();
        $temp_year = new Academic_Year();
        if($latest_year == null){
            $curr_month = intval(date('m', time()));
            if($curr_month >= 2 && $curr_month <= 12){
                $temp_year->starting_year = date('Y', time());
                $temp_year->ending_year = $temp_year->starting_year + 1;
                if($curr_month >= 2 && $curr_month <= 8){
                    // Odd semester
                    $temp_year->odd_semester = true;
                }
                else if($curr_month > 8 && $curr_month <= 12){
                    // Even semester starting current year
                    $temp_year->odd_semester = false;
                }
            }
            else if($curr_month == 1){
                // Even semester starting prev year
                $temp_year->starting_year = intval(date('Y', time()))-1;
                $temp_year->ending_year = $temp_year->starting_year + 1;
                $temp_year->odd_semester = false;
            }
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

        session()->put('success_notif', 'You have successfuly CREATED 1 new academic year record!');
        return redirect(route('staff.academic-year.page'));
    }

    public function confirm_delete($academic_year_id){
        $academic_year = Academic_Year::where('id', $academic_year_id)->first();
        if($academic_year != null){
            session()->put('reffered_academic_year_id', $academic_year->id);
            return response()->json([
                'reffered_academic_year' => $academic_year,
                'failed' => false
            ]);
        }

        return response()->json(['failed' => true]);
    }

    public function delete(){
        $academic_year = Academic_Year::find(session('reffered_academic_year_id'));
        $academic_year->delete();
        session()->forget('reffered_academic_year_id');

        session()->put('success_notif', 'You have successfuly DELETED 1 new academic year record!');
        return redirect(route('staff.academic-year.page'));
    }
}