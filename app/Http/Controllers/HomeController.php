<?php

namespace App\Http\Controllers;

use App\Academic_Year;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function staff_index(){
        return view('staff_side\home', ['academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get()]);
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
 