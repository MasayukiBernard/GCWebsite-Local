<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Major;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ManageStudentController extends Controller
{
    private function create_new_student($nim, $pass){
        $user = new User();
        $user->password = Hash::make($pass);
        $user->name = '-';
        $user->gender = '-';
        $user->email = Str::random(10) . '@binus.ac.id';
        $user->mobile = '-';
        $user->telp_num = '-';
        $user->save();

        $student = new Student();
        $student->nim = $nim;
        $student->user_id = $user->id;
        $student->major_id = 1;
        $student->place_birth = '-';
        $student->date_birth = date('Y-m-d', 0);
        $student->nationality = '-';
        $student->address = '-';
        $student->picture_path = 'students\pictures\Dummy_PP.png';
        $student->id_card_picture_path = '-';
        $student->flazz_card_picture_path = '-';
        $student->binusian_year = 2000 + (int) Str::substr($nim, 0, 2);
        $student->save();
    }

    public function show_studentPage(){
        $binusian_year = DB::table('students')->select('binusian_year')->orderByDesc('binusian_year')->first();
        $students = null;
        if($binusian_year != null){
            $students = Student::where('binusian_year', $binusian_year->binusian_year)->orderBy('nim')->get();
        }
        return view('staff_side/master_student/view', ['students' => $students, 'binusian_years' => DB::table('students')->select('binusian_year')->distinct()->orderBy('binusian_year', 'desc')->get()]);
    }

    public function show_StudentsByYear($year, $field, $sort_type){
        $available_fields = array('nim', 'name', 'major_name', 'nationality');
        $sort_types = array('a' => 'asc', 'd' => 'desc');

        if(is_numeric($year) && in_array($field, $available_fields) && Arr::exists($sort_types, $sort_type)){
            $students = DB::table('students')
                    ->join('users', 'students.user_id', '=', 'users.id')
                    ->join('majors', 'students.major_id', '=', 'majors.id')
                    ->select('students.user_id as user_id', 'students.nim as nim', 'users.name as name', 'majors.name as major_name', 'students.nationality as nationality')
                    ->where('binusian_year', $year)
                    ->orderBy($field, $sort_types[$sort_type])
                    ->get();
            
            if($students->first() != null){
                return response()->json([
                    'students' => $students,
                    'failed' => false
                ]);
            }
        }

        return response()->json(['failed' => true]);
    }

    public function show_createPage(){
        return view('staff_side/master_student/create-type');
    }

    public function download_template(){
        return Storage::disk('private')->download('staffs/templates/create-batch-student-template.xlsx');
    }

    public function show_createSinglePage(){
        return view('staff_side/master_student/create-single');
    }

    public function confirm_create_single(Request $request){
        $first_major_id = DB::table('majors')->select('id')->first();
        if($first_major_id == null){
            // Failed, notice to make a major first
            return redirect(route('staff.student.create-page'));
        }

        $request->flash();
        $validatedData = $request->validate([
            'nim' => ['required', 'string', 'digits:10'],
            'password' => ['required', 'string', 'max:100']
        ]);
        $request->session()->put('validatedData', $validatedData);
        $validatedData['password'] = Str::substr($validatedData['password'], 0, 5) . '.......';

        return view ('staff_side/master_student/confirm-create-single', ['validatedData' => $validatedData, 'first_major' => Major::find($first_major_id->id)]);
    }

    public function create_single(){
        $input = session('validatedData');
        $this->create_new_student($input['nim'], $input['password']);
        session()->forget('validatedData');

        return redirect(route('staff.student.page'));
    }

    public function show_createBatchPage(){
        $view_data = [];
        if(session('template_error') == true){
            $view_data = ['error' => true];
            session()->forget('template_error');
        }
        return view('staff_side/master_student/create-batch', $view_data);
    }

    public function confirm_create_batch(Request $request){
        $first_major_id = DB::table('majors')->select('id')->first();
        if($first_major_id == null){
            // Failed, notice to make a major first
            return redirect(route('staff.student.create-page'));
        }
        
        $validator = Validator::make($request->all(),[
            'batch-students' => ['required', 'mimes:txt', 'mimetypes:text/plain']
        ],[],
        [
            'batch-students' => 'uploaded file'
        ]);
        
        if ($validator->fails()) {
            return redirect(route('staff.student.create-page-batch'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $temp_file_path = Storage::disk('private')->putFile('staffs/temp/batch_students_templates', $request->file('batch-students'));
        $request->session()->put('uploaded_temp_file_path', $temp_file_path);
        $file_data = Storage::disk('private')->get($temp_file_path);

        if (strcmp(substr($file_data, 29, 14), "NIM\tPassword\r\n") == 0){
            $trimmed_data = Str:: after($file_data, "NIM\tPassword\r\n");

            $current = Str::before($trimmed_data, "\r\n");
            $next = Str::after($trimmed_data, "\r\n");

            $must_be_nim_regex = '/\d{10}/';
            $must_be_pass_regex = '/^[^\s]([a-zA-Z0-9_~`\\-!@#\\$%\\^&\\*\\(\\)-\\+=\\{}\\[\\]\\\\\\|:";\'<>,\\.\\?\/])+\\z/';  

            $enrolling_students = array();

            $i = 0;
            while(!empty($current) && strcmp($current, "\t") != 0){
                $nim = Str::before($current, "\t");
                $pass = Str::between($current, "\t", "\r");
                if(!preg_match($must_be_nim_regex, $nim) || !preg_match($must_be_pass_regex, $pass) || strlen($pass) > 100){
                    // Return error response
                    session()->put('template_error', true);
                    return redirect(route('staff.student.create-page-batch'));
                }
                $enrolling_students[] = array("nim" => $nim, "password" => $pass);
                $current = Str::before($next, "\r\n");
                $next = Str::after($next, "\r\n");
            }
        }

        return view('staff_side/master_student/confirm-create-batch', ['enrolling_students' => $enrolling_students, 'first_major' => Major::find($first_major_id->id)]);
    }

    public function create_batch(){
        if(session('uploaded_temp_file_path') != null){
            $temp_file_path = session('uploaded_temp_file_path');
            session()->forget('uploaded_temp_file_path');
            $file_data = Storage::disk('private')->get($temp_file_path);

            $trimmed_data = Str:: after($file_data, "NIM\tPassword\r\n");
            $current = Str::before($trimmed_data, "\r\n");
            $next = Str::after($trimmed_data, "\r\n");

            while(!empty($current) && strcmp($current, "\t") != 0){
                $nim = Str::before($current, "\t");
                $pass = Str::between($current, "\t", "\r");

                $this->create_new_student($nim, $pass);

                $current = Str::before($next, "\r\n");
                $next = Str::after($next, "\r\n");
            }
        }
        return redirect(route('staff.student.page'));
    }

    public function show_studentDetails(User $user){
        session()->put('latest_requested_student_uid', $user->id);
        return view('staff_side/master_student/detailed', ['referred_user' => $user]);
    }

    public function delete(){
        $user = User::where('id', session('latest_requested_student_uid'))->first();
        if($user != null){
            session()->forget('latest_requested_student_uid');
            $user->delete();
        }
        return redirect(route('staff.student.page'));
    }
}
