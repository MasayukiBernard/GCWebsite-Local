<?php

namespace App\Http\Controllers;

use App\Academic_Year;
use App\Major;
use App\Student_Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    private function count_percentages($major_id, $academic_year_id, $responseType){
        $academic_year = Academic_Year::where('id', $academic_year_id)->first();
        if($academic_year != null){
            $yearly_students = $academic_year->yearly_students;
            $total_student = 0;
            if($major_id == 0){
                // Total students of all majors
                $total_student = $yearly_students->count();
            }
            $is_submitted = 0;
            $is_nominated = 0;

            $major = Major::where('id', $major_id)->first();
            if($major != null && $major_id > 0){
                // Submitted CSA Form and Nominated Student sum per Academic Year by Major Type
                foreach($yearly_students as $yearly_student){
                    if($yearly_student->student->major->id == $major_id){
                        ++$total_student;

                        if($yearly_student->csa_form != null && $yearly_student->csa_form->is_submitted == true){
                            $is_submitted++;
                        }
                        if($yearly_student->is_nominated){
                            $is_nominated++;
                        }
                    }
                }    
            }
            else if ($major_id == 0){
                foreach($yearly_students as $yearly_student){
                    if($yearly_student->csa_form != null && $yearly_student->csa_form->is_submitted == true){
                        $is_submitted++;
                    }
                    if($yearly_student->is_nominated){
                        $is_nominated++;
                    }
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
                $submitted_percentage = $nominated_percentage = '-';
                if($total_student != 0){
                    $submitted_percentage = round($is_submitted / $total_student * 100, 2) . '%';
                    $nominated_percentage = round($is_nominated / $total_student * 100, 2) . '%';
                }
                return array(
                    "year" => $academic_year->starting_year . '/' . $academic_year->ending_year . ' - ' . ($academic_year->odd_semester ? 'Odd' : 'Even'),
                    "submitted_percentage" => $submitted_percentage,
                    "nominated_percentage" => $nominated_percentage,
                    "is_submitted" => $is_submitted,
                    "con_is_submitted" => $total_student - $is_submitted,
                    "total_student" => $total_student,
                    "is_nominated" => $is_nominated,
                    "con_is_nominated" => $total_student - $is_nominated,
                );
            }
        }

        return "FAILED";
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function staff_index(){
        
        $majors = Major::orderBy('name')->get();
        $academic_years = Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get();
        
        $student_requests = Student_Request::where('is_approved', null)->orderBy('latest_created_at', 'asc')->count();

        if($academic_years->count() > 0){
            $initial_percentages = $this->count_percentages(0, $academic_years->first()->id, "HTML5");
        
            if(strcmp(gettype($initial_percentages), "array") === 0){
                return view('staff_side\home', [
                    'academic_years' => $academic_years,
                    'majors' => $majors,
                    'initial_percentages' => $initial_percentages,
                    'student_requests' => $student_requests
                ]);
            }
        }
        return view('staff_side\home', [
            'failed' => true,
            'student_requests' => $student_requests
        ]);
    }
    
    public function student_index(){
        session()->forget(['csa_form_id', 'csa_form_yearly_student_id']);
        return view('student_side\home', ['user_verified' => is_null(Auth::user()->email_verified_at) ? false : true]);
    }

    public function get_percentages($major_id, $academic_year_id){
        $json_response_data = $this->count_percentages($major_id, $academic_year_id, "JSON");
        if($json_response_data !== "FAILED"){
            return response()->json([
                'submitted_csa_forms' => $json_response_data['is_submitted'],
                'total_yearly_students' => $json_response_data['total_student'],
                'nominated_students' =>$json_response_data['is_nominated'],
                'failed' => false
            ]);
        }
        else{
            return response()->json(['failed' => true]);
        }
        
    }
}
 