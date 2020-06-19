<?php

namespace App\Http\Controllers\Staff;

use App\Academic_Year;
use App\Http\Controllers\Controller;
use App\Student;
use App\Yearly_Student;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ManageYearlyStudentController extends Controller
{
    private function unpicked_students($id, $year){
        $student_at_year_nims = DB::table('yearly_students')->select('nim')->where('academic_year_id', $id)->get();
        return DB::table('students')->select('nim', 'user_id')->whereNotIn('nim', Arr::pluck($student_at_year_nims, 'nim'))->where('binusian_year', $year)->orderBy('nim')->get();
    }

    private function students_users($students){
        return DB::table('users')->select('id', 'name')->whereIn('id', Arr::pluck($students, 'user_id'))->get();
    }

    public function show_yearlyStudentPage(){
        return view('staff_side\yearly_student\view', ['academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get()]);
    }

    public function show_yearlyStudentDetails($academic_year_id){
        $academic_year = Academic_Year::where('id', $academic_year_id)->first();
        if($academic_year == null){
            abort(404);
        }
    
        session()->put('latest_yearly_student_year_id', $academic_year_id);
        return view('staff_side\yearly_student\details', [
            'yearly_students' => Yearly_Student::where('academic_year_id', $academic_year_id)->orderBy('nim')->get(), 
            'academic_year' => $academic_year
        ]);
    }

    public function show_createPage(){
        return view('staff_side\yearly_student\create', [
            'academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get(),
            'binusian_years' => DB::table('students')->select('binusian_year')->orderBy('binusian_year', 'desc')->distinct()->get(),
        ]);
    }

    public function show_unpicked_students($id, $year){
        $academic_year = Academic_Year::where('id', $id)->first();
        $student_at_year = Student::where('binusian_year', $year)->first();
        if($academic_year != null && $student_at_year != null){
            $students = $this->unpicked_students($id, $year);
            $users = $this->students_users($students);
            return response()->json([
                'students' => $students,
                'students_users' => $users,
                'failed' => false
            ]);
        }
        return response()->json(['failed' => true]);
    }

    public function confirm_create(Request $request){
        $validator = Validator::make($request->all(), 
        [
            'academic-year' => ['required', 'integer', 'exists:academic_years,id'],
            'binusian-year' => ['required', 'integer'],
            'enrolling-students' => ['required', 'exists:students,nim']
        ],[], 
        [
            'academic-year' => 'academic year',
            'binusian-year' => 'binusian year',
            'enrolling-students' => 'students enrolling current year'
        ]);

        if($validator->fails()){
            return redirect(route('staff.yearly-student.create-page'))
                    ->withErrors($validator)
                    ->withInput();
        }

        $request->session()->put('create_yearly_students', ['academic_year_id' => $request['academic-year'], 'students' => $request->input('enrolling-students')]);
        return view('staff_side\yearly_student\confirm-create', ['referred_year' => Academic_Year::where('id', $request['academic-year'])->first(), 'students' => Student::whereIn('nim', $request->input('enrolling-students'))->get()]);
    }

    public function create(){
        if(session('create_yearly_students') != null){
            $academic_year_id = session('create_yearly_students')['academic_year_id'];
            $enrolling_students = session('create_yearly_students')['students'];
            foreach($enrolling_students as $enrolling_student){
                $yearly_student = new Yearly_Student();
                $yearly_student->nim = $enrolling_student;
                $yearly_student->academic_year_id = $academic_year_id;
                $yearly_student->save(); 
            }
            session()->forget(['latest_yearly_student_year_id', 'create_yearly_students']);
        }
        return redirect(route('staff.yearly-student.page'));
    }

    public function confirm_delete($yearly_student_id){
        $yearly_student = Yearly_Student::where('id', $yearly_student_id)->first();
        if($yearly_student != null){
            $academic_year = $yearly_student->academic_year->starting_year . '/' . $yearly_student->academic_year->ending_year . ' - ' . ($yearly_student->academic_year->odd_semester ? 'Odd' : 'Even');
            session()->put('yearly_student_id_to_delete', $yearly_student_id);
            return response()->json([
                'yearly_student_nim' => $yearly_student->nim,
                'yearly_student_name' => $yearly_student->student->user->name, 
                'academic_year' => $academic_year,
                'failed' => false
            ]);
        }
        return response()->json(['failed' => true]);
    }

    public function delete(){
        $yearly_student = Yearly_Student::where('id', session('yearly_student_id_to_delete'))->first();
        if($yearly_student != null){
            session()->forget('yearly_student_id_to_delete');
            $yearly_student->delete();
        }
        return redirect(route('staff.yearly-student.page'));
    }
}
