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
        $student->major_id = Major::orderBy('name')->first()->id;
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

    public function set_students(Request $request){
        $validatedData = $request->validate([
            'sum' => ['required', 'numeric', 'min:1']
        ]);

        session()->forget('set_student_sum');
        session()->put('set_student_sum', $validatedData['sum']);

        return redirect(route('staff.student.create-page'));
    }

    public function show_createPage(){
        session()->forget('create_students');
        
        $first_major_id = Major::first();
        if($first_major_id == null){
            session()->put('failed_notif', 'Cannot make new student record(s) yet, please make at least 1 major record!');
            return redirect(route('staff.student.page'));
        }

        return view('staff_side\master_student\create');
    }

    public function confirm_create(Request $request){
        $first_major_id = Major::orderBy('name')->first();
        if($first_major_id == null){
            session()->put('failed_notif', 'Cannot make new student record(s) yet, please make at least 1 major record!');
            return redirect(route('staff.student.page'));
        }

        $validator = Validator::make($request->all(), [
            'nims.*' => ['required_with:passwords.*', 'nullable', 'string', 'digits:10', 'distinct', 'unique:students,nim'],
            'passwords.*' => ['required_with:nims.*', 'nullable', 'string', 'max:100', 'regex:/\\A[a-zA-Z0-9`~!@#\\$%\\^&\\*\\(\\)_\\-\\+=\\[\\{\\]\\}\\\\\\|;:\\\'",<\\.>\\/\\?]+\\z/']
        ], [], [
            'nims.*' => 'nim',
            'passwords.*' => 'password'
        ]);

        if ($validator->fails()) {
            return redirect(route('staff.student.create-page'))
                        ->withErrors($validator)
                        ->withInput();
        }

        $request->session()->put('create_students', $request->except('_token'));

        return view('staff_side\master_student\confirm-create',[
            'first_major' => Major::orderBy('name')->first(),
            'enrolling_students' => $request->except('_token')
        ]);
    }

    public function create(){
        $first_major_id = Major::orderBy('name')->first();
        if($first_major_id == null){
            session()->put('failed_notif', 'Cannot make new student record(s) yet, please make at least 1 major record!');
            return redirect(route('staff.student.page'));
        }

        $sess_data = session('create_students');
        if($sess_data != null){
            $i = 0;
            $total = 0;
            foreach($sess_data['nims'] as $nim){
                if($nim != null && $sess_data['passwords'][$i] != null){
                    $this->create_new_student($nim, $sess_data['passwords'][$i]);
                    ++$total;
                }
                ++$i;
            }

            session()->put('success_notif', 'You have successfuly CREATED ' . $total . ' new student record!');
        }

        session()->forget(['set_student_sum', 'create_students']);
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
