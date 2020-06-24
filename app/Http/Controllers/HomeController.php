<?php

namespace App\Http\Controllers;

use App\Academic_Year;

class HomeController extends Controller
{
    private function count_percentages($id, $responseType){
        $academic_year = Academic_Year::where('id', $id)->first();
        if($academic_year != null){
            $yearly_students = $academic_year->yearly_students;
            $total_student = $yearly_students->count();
            $is_submitted = 0;
            $is_nominated = 0;
            foreach($yearly_students as $yearly_student){
                if($yearly_student->csa_form != null && $yearly_student->csa_form->is_submitted == true){
                    $is_submitted++;
                }
                if($yearly_student->is_nominated){
                    $is_nominated++;
                }
            }
            
            if($responseType === "JSON"){
                return array(
                    "is_submitted" => $is_submitted,
                    "total_student" => $total_student,
                    "is_nominated" => $is_nominated,
                );
            }
            else if($responseType === "HTML5"){
                $submitted_percentage = round($is_submitted / $total_student * 100, 2);
                $nominated_percentage = round($is_nominated / $total_student * 100, 2);
                return array(
                    "year" => $academic_year->starting_year . '/' . $academic_year->ending_year . ' - ' . ($academic_year->odd_semester ? 'Odd' : 'Even'),
                    "submitted_percentage" => $submitted_percentage,
                    "nominated_percentage" => $nominated_percentage
                );
            }
        }
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function staff_index(){
        $academic_years = Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get();

        if($academic_years->count() > 0){
            $initial_percentages = $this->count_percentages($academic_years->first()->id, "HTML5");
        
            if(strcmp(gettype($initial_percentages), "array") === 0){
                return view('staff_side\home', [
                    'academic_years' => $academic_years,
                    'initial_percentages' => $initial_percentages
                ]);
            }
        }
        return view('staff_side\home', [
            'failed' => true
        ]);
    }
    
    public function student_index(){
        return view('student_side\home');
    }

    public function get_percentages($id){
        // Submitted CSA Form and Nominated Student percentage per Academic Year
        $academic_year = Academic_Year::where('id', $id)->first();
        if($academic_year != null){
            $yearly_students = $academic_year->yearly_students;
            $total_student = $yearly_students->count();
            $is_submitted = 0;
            $is_nominated = 0;
            foreach($yearly_students as $yearly_student){
                if($yearly_student->csa_form != null && $yearly_student->csa_form->is_submitted == true){
                    $is_submitted++;
                }
                if($yearly_student->is_nominated){
                    $is_nominated++;
                }
            }
            return response()->json([
                'submitted_csa_forms' => $is_submitted,
                'total_yearly_students' => $total_student,
                'nominated_students' =>$is_nominated
            ]);
        }
        else{
            return response()->json(['empty' => true]);
        }
        
    }
}
 