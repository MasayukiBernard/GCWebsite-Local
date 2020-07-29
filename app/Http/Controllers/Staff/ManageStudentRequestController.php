<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Student_Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ManageStudentRequestController extends Controller{

    private function get_studentRequest($student_request_id){
        return DB::table('student_requests')
                ->where('student_requests.latest_deleted_at', null)->where('student_requests.is_approved', null)->where('student_requests.id', $student_request_id)
                ->join('students', 'student_requests.nim', '=', 'students.nim')
                ->join('users', 'students.user_id' , '=', 'users.id')
                ->select('student_requests.id', 'student_requests.nim', 'student_requests.request_type', 'users.name')
                ->first();
    }

    public function show_approvalPage(){
        $student_requests = DB::table('student_requests')
                                ->where('student_requests.latest_deleted_at', null)->where('is_approved', null)
                                ->join('students', 'student_requests.nim', '=', 'students.nim')
                                ->join('users', 'students.user_id' , '=', 'users.id')
                                ->orderBy('student_requests.latest_created_at', 'asc')
                                ->select('student_requests.*', 'users.name')
                                ->get();

        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        else if (session('failed_notif') != null){
            $failed = session('failed_notif');
        }

        session()->forget(['success_notif', 'failed_notif']);
        return view('staff_side\student-request-approval', [
            'student_requests' => $student_requests,
            'success' => $success,
            'failed' => $failed
        ]);
    }

    public function notify_request($student_request_id){
        $student_request = $this->get_studentRequest($student_request_id);
        
        if($student_request != null){
            session()->put('notified_student_request_id', $student_request_id);
            return response()->json([
                'student_request' => $student_request,
                'failed' => false
            ]);
        }

        return response()->json(['false' => true]);
    }

    public function deny_request(){
        $student_request = Student_Request::where('id', session('notified_student_request_id'))->first();

        if($student_request != null){
            $student_request->is_approved = false;
            $student_request->staff_id = Auth::user()->staff->id;
            $student_request->save();
            session()->put('success_notif', 'You have successfuly denied a student request!');
        }
        else{
            session()->put('failed_notif', 'Failed to deny a student request!');
        }

        session()->forget('notified_student_request_id');
        return redirect(route('staff.student-request.page'));
    }

    public function approve_request(){
        $student_request = Student_Request::where('id', session('notified_student_request_id'))->first();

        if($student_request != null){
            $student_request->is_approved = true;
            $student_request->staff_id = Auth::user()->staff->id;
            $student_request->save();

            $student_request->student->is_finalized = false;
            $student_request->student->save();
            session()->put('success_notif', 'You have successfuly approved a student request!');
        }
        else{
            session()->put('failed_notif', 'Failed to approved a student request!');
        }

        session()->forget('notified_student_request_id');
        return redirect(route('staff.student-request.page'));
    }
}