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
        $user->latest_updated_at = null;
        $user->save();

        $student = new Student();
        $student->nim = $nim;
        $student->user_id = $user->id;
        $student->major_id = session('first_major_id');
        $student->place_birth = '-';
        $student->date_birth = date('Y-m-d', 0);
        $student->nationality = '-';
        $student->address = '-';
        $student->picture_path = '-';
        $student->id_card_picture_path = '-';
        $student->flazz_card_picture_path = '-';
        $student->binusian_year = 2000 + (int) Str::substr($nim, 0, 2);
        $student->latest_updated_at = null;
        $student->save();
    }

    public function show_studentPage(){
        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        else if (session('failed_notif') != null){
            $failed = session('failed_notif');
        }
        session()->forget(['success_notif', 'failed_notif']);

        $binusian_years = DB::table('students')
                            ->select('binusian_year')->distinct()
                            ->where('latest_deleted_at', null)
                            ->orderByDesc('binusian_year')
                            ->get();
        $students = null;
        if($binusian_years->first() != null){
            $students = Student::where('binusian_year', $binusian_years->first()->binusian_year)->orderBy('nim')->get();
        }

        return view('staff_side/master_student/view', [
            'students' => $students,
            'binusian_years' => $binusian_years,
            'success' => $success,
            'failed' => $failed
        ]);
    }

    public function show_StudentsByYear($year, $field, $sort_type){
        $available_fields = array('nim', 'name', 'major_name', 'nationality');
        $sort_types = array('a' => 'asc', 'd' => 'desc');

        if(is_numeric($year) && in_array($field, $available_fields) && Arr::exists($sort_types, $sort_type)){
            $students = DB::table('students')
                        ->join('users', 'students.user_id', '=', 'users.id')
                        ->join('majors', 'students.major_id', '=', 'majors.id')
                        ->select('students.user_id as user_id', 'students.nim as nim', 'users.name as name', 'majors.name as major_name', 'students.nationality as nationality')
                        ->where('users.latest_deleted_at', null)->where('majors.latest_deleted_at', null)->where('binusian_year', $year)
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
        $first_major_id = Major::first();
        if($first_major_id == null){
            session()->put('failed_notif', 'Cannot make new student record(s) yet, please make at least 1 major record!');
            return redirect(route('staff.student.page'));
        }
        return view('staff_side/master_student/create-type');
    }

    public function download_template(){
        return Storage::disk('private')->download('staffs/templates/create-batch-student-template.xlsx');
    }

    public function show_createSinglePage(){
        return view('staff_side/master_student/create-single');
    }

    public function confirm_create_single(Request $request){
        $first_major_id = Major::first();
        if($first_major_id == null){
            session()->put('failed_notif', 'Cannot make new student record(s) yet, please make at least 1 major record!');
            return redirect(route('staff.student.page'));
        }

        $request->flash();
        $validatedData = $request->validate([
            'nim' => ['required', 'string', 'digits:10', 'unique:students,nim'],
            'password' => ['required', 'string', 'max:100']
        ]);
        $request->session()->put('validatedData', $validatedData);
        $validatedData['password'] = Str::substr($validatedData['password'], 0, 5) . '.......';

        $request->session()->put('first_major_id', $first_major_id->id);
        return view ('staff_side/master_student/confirm-create-single', ['validatedData' => $validatedData, 'first_major' => Major::find($first_major_id->id)]);
    }

    public function create_single(){
        $selected_major = Major::where('id', session('first_major_id'))->first();
        if($selected_major == null){
            session()->put('failed_notif', 'Failed to create student record! Missing referred major record!');
            return redirect(route('staff.student.page'));
        }

        $input = session('validatedData');
        $this->create_new_student($input['nim'], $input['password']);
        session()->forget('validatedData');

        session()->put('success_notif', 'You have successfuly CREATED 1 new student record!');
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
        $first_major_id = Major::first();
        if($first_major_id == null){
            session()->put('failed_notif', 'Cannot make new student record(s) yet, please make at least 1 major record!');
            return redirect(route('staff.student.page'));
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
                $enrolling_students[] = array("nim" => $nim, "password" => Str::substr($pass, 0, 5) . '......');
                $current = Str::before($next, "\r\n");
                $next = Str::after($next, "\r\n");
            }
        }

        $request->session()->put('first_major_id', $first_major_id->id);
        return view('staff_side/master_student/confirm-create-batch', [
            'enrolling_students' => $enrolling_students, 
            'first_major' => Major::find($first_major_id->id)
        ]);
    }

    public function create_batch(){
        if(session('uploaded_temp_file_path') != null){
            $selected_major = Major::where('id', session('first_major_id'))->first();
            if($selected_major == null){
                session()->put('failed_notif', 'Failed to create student record(s)! Missing major record!');
                return redirect(route('staff.student.page'));
            }

            $temp_file_path = session('uploaded_temp_file_path');
            session()->forget('uploaded_temp_file_path');
            $file_data = Storage::disk('private')->get($temp_file_path);

            $trimmed_data = Str:: after($file_data, "NIM\tPassword\r\n");
            $current = Str::before($trimmed_data, "\r\n");
            $next = Str::after($trimmed_data, "\r\n");

            $total = 0;
            while(!empty($current) && strcmp($current, "\t") != 0){
                $nim = Str::before($current, "\t");
                $pass = Str::between($current, "\t", "\r");

                $this->create_new_student($nim, $pass);

                $current = Str::before($next, "\r\n");
                $next = Str::after($next, "\r\n");
                ++$total;
            }

            session()->put('success_notif', 'You have successfuly CREATED ' . $total . ' new student record!');
        }

        return redirect(route('staff.student.page'));
    }

    public function show_studentDetails(User $user){
        session()->put('latest_requested_student_uid', $user->id);

        $pp_path = Storage::disk('private')->exists($user->student->picture_path);
        $ic_path = Storage::disk('private')->exists($user->student->id_card_picture_path);
        $fc_path = Storage::disk('private')->exists($user->student->flazz_card_picture_path);

        return view('staff_side/master_student/detailed', [
            'referred_user' => $user,
            'filemtimes' => [
                'pp' => $pp_path == true ? filemtime(storage_path('app\private\\' . $user->student->picture_path)) : '0',
                'ic'=> $ic_path == true ? filemtime(storage_path('app\private\\' . $user->student->id_card_picture_path)) : '0',
                'fc'=> $fc_path == true ? filemtime(storage_path('app\private\\' . $user->student->flazz_card_picture_path)) : '0'
            ]
        ]);
    }

    public function delete(){
        $user = User::where('id', session('latest_requested_student_uid'))->first();
        if($user != null){
            session()->forget('latest_requested_student_uid');
            $user->delete();
            session()->put('success_notif', 'You have successfuly DELETED 1 student record!');
        }
        else{
            session()->put('failed_notif', 'System failed to delete student record!');
        }

        return redirect(route('staff.student.page'));
    }
}
