<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Achievement;
use App\Academic_Info;
use App\Choice;
use App\Condition;
use App\CSA_Form;
use App\Emergency;
use App\English_Test;
use App\Http\Requests\CSAAcademicInfo;
use App\Major;
use App\Notifications\CSAFormCreated;
use App\Notifications\CSAFormSubmitted;
use App\Partner;
use App\Passport;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageCSAFormController extends Controller
{
    private function mail_notifyCSAFormCreation($yearly_student_id){
        $user = Auth::user();
        $user->notify(new CSAFormCreated($user->student->yearly_students()->where('id', $yearly_student_id)->first()->academic_year));
    }

    private function mail_notifyCSAFormSubmission($yearly_student_id){
        $user = Auth::user();
        $user->notify(new CSAFormSubmitted($user->student->yearly_students()->where('id', $yearly_student_id)->first()->academic_year));
    }

    public function show_initialView(){
        $user = Auth::user();
        $student = $user->student;
        $nim = $student->nim;
        $yearly_students_academic_year = DB::table('yearly_students')
                                ->select('academic_years.*', 'yearly_students.id as ys_id')
                                ->where('yearly_students.latest_deleted_at', null)->where('nim', $nim)
                                ->join('academic_years', 'academic_years.id', '=', 'yearly_students.academic_year_id')
                                ->get();

        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        if(session('failed_notif') != null){
            $failed = session('failed_notif');
        }

        session()->forget(['csa_form_id', 'csa_form_yearly_student_id','success_notif', 'failed_notif']);

        return view('student_side\csa-form\csa-mainpage', [
            'yearly_students_academic_year' => $yearly_students_academic_year,
            'success' => $success,
            'failed' => $failed
        ]);
    }
    
    public function set_ysid_session(Request $request){
        $yearly_student = Auth::user()->student->yearly_students()->where('academic_year_id', $request['ys-id'])->first();
        
        if($yearly_student != null){
            session()->put('csa_form_yearly_student_id', $yearly_student->id);
            return redirect(route('student.csa-form.csa-page1'));    
        }

        session()->put('failed_notif', 'Please pick the enrolled academic year from the provided list!');
        return redirect(route('student.csa-form.csa-mainpage'));
    }

    public function show_createPage(){
        if(session('csa_form_yearly_student_id') != null){
            $yearly_student = Auth::user()->student->yearly_students()->where('id', session('csa_form_yearly_student_id'))->first();

            if($yearly_student != null){
                return view('student_side\csa-form\create-csa-form',['academic_year' => $yearly_student->academic_year]);
            }
            session()->put('failed_notif', 'Missing enrollment in academic year!');
        }
        return redirect(route('student.csa-form.csa-mainpage'));
    }

    public function create(){
        $create_form_ysid = session('csa_form_yearly_student_id');
        if($create_form_ysid != null){
            $csa_form = new CSA_Form();
            $csa_form->yearly_student_id = $create_form_ysid;
            $csa_form->latest_updated_at = null;
            $csa_form->save();

            $this->mail_notifyCSAFormCreation($create_form_ysid);

            return redirect(route('student.csa-form.csa-page1'));
        }

        session()->put('failed_notif', 'Failed to create a csa application form!');
        return redirect(route('student.csa-form.csa-mainpage'));
    }

    public function show_insertPage1(){
        $user = Auth::user();
        $student = $user->student;
        $nim = $student->nim;

        $pp_path = Storage::disk('private')->exists($user->student->picture_path);
        $ic_path = Storage::disk('private')->exists($user->student->id_card_picture_path);
        $fc_path = Storage::disk('private')->exists($user->student->flazz_card_picture_path);
        
        return view('student_side\csa-form\csa-page1',[
            'user' => $user,
            'user_student' => $student,
            'filemtimes' => [
                'pp' => $pp_path == true ? filemtime(storage_path('app\private\\' . $user->student->picture_path)) : '0',
                'ic' => $ic_path == true ? filemtime(storage_path('app\private\\' . $user->student->id_card_picture_path)) : '0',
                'fc' => $fc_path == true ? filemtime(storage_path('app\private\\' . $user->student->flazz_card_picture_path)) : '0'
            ],
        ]);
    }

    public function goto_page2(){
        return redirect(route('student.csa-form.csa-page2'));
    }

    public function show_insertPage2(){
        $csa_form = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first();
        session()->put('csa_form_id', $csa_form->id);

        $major = $csa_form->yearly_student->student->major->name;
        $academic_info = Academic_Info::where('csa_form_id', $csa_form->id)->first();
        $english_test = English_Test::where('csa_form_id', $csa_form->id)->first();

        $gpa = $academic_info != null ? Storage::disk('private')->exists($academic_info->gpa_proof_path) : false;
        $e_test = $english_test != null ? Storage::disk('private')->exists($english_test->proof_path) : false;

        return view('student_side\csa-form\csa-page2', [
            'major' => $major,
            'academic_info' => $academic_info != null ? $academic_info : null,
            'english_test' => $english_test != null ? $english_test : null,
            'ysid' => session('csa_form_yearly_student_id'),
            'filemtimes' => [
                'gpa' => $gpa ? filemtime(storage_path('app\private\\' . $academic_info->gpa_proof_path)) : '0',
                'e-test' => $e_test ? filemtime(storage_path('app\private\\' . $english_test->proof_path)) : '0'
            ]
        ]);
    }

    public function page2_insert(CSAAcademicInfo $request){
        // if no Academic_Info and English_Test record
            // Creates Academic_Info and English_Test record
        // else
            // display, existing db data along with images

        $validatedData = $request->validated();

        $academic_info = Academic_Info::where('csa_form_id', session('csa_form_id'))->first();
        $english_test = English_Test::where('csa_form_id', session('csa_form_id'))->first();
        if($academic_info == null && $english_test == null){
            $academic_info = new Academic_Info();
            $academic_info->csa_form_id = session('csa_form_id');
            $academic_info->major_id = Auth::user()->student->major->id;
            $academic_info->class = 0;
            $academic_info->latest_updated_at = null;

            $english_test = new English_Test();
            $english_test->csa_form_id = session('csa_form_id');
            $english_test->latest_updated_at = null;
        }
        
        // Academic Info
        $campuses = array('Alam Sutera', 'Kemanggisan');

        if(Arr::exists($validatedData, 'gpa-proof')){
            if($academic_info->gpa_proof_path != null){
                Storage::disk('private')->move($academic_info->gpa_proof_path, 'students/trashed/gpa_transcripts/' . Str::afterLast($academic_info->gpa_proof_path, '/'));
            }
            $academic_info->gpa_proof_path = Storage::disk('private')->putFile('students/gpa_transcripts', $validatedData['gpa-proof']);
            Arr::forget($validatedData, 'gpa-proof');
        }

        $academic_info->campus = $campuses[$validatedData['campus']];
        $academic_info->study_level = $validatedData['study-level'];
        $academic_info->semester = $validatedData['semester'];
        $academic_info->gpa = $validatedData['gpa'];

        $academic_info->save();

        // English Test
        $test_types = array('IELTS', 'TOEFL');

        if(!(Arr::exists($validatedData, 'test-type'))){
            $capitalized = Str::upper($validatedData['other-test']);
            foreach ($test_types as $type){
                if($type == $capitalized){
                    if($type == 'IELTS'){
                        $validatedData['test-type'] = 0;
                    }
                    else if($type == 'TOEFL'){
                        $validatedData['test-type'] = 1;
                    }
                }
            }
            $english_test->test_type = $capitalized;
        }
        else{
            $english_test->test_type = $test_types[$validatedData['test-type']];
        }

        if(Arr::exists($validatedData, 'proof-path')){
            if($english_test->proof_path != null){
                Storage::disk('private')->move($english_test->proof_path, 'students/trashed/english_tests/' . Str::afterLast($english_test->proof_path, '/'));
            }
            $english_test->proof_path = Storage::disk('private')->putFile('students/english_tests/' . (Arr::exists($validatedData, 'test-type') ? 'Other' : $test_types[$validatedData['test-type']]), $validatedData['proof-path']);
        }

        $english_test->score = $validatedData['score'];
        $english_test->test_date = $validatedData['test-date'];

        $english_test->save();

        return redirect(route('student.csa-form.csa-page3'));
    }

    public function show_insertPage3(){
        // if no Achievements record
            // Creates Achievements record
        // else
            // display, existing db record along with proof image

        $achievement = Achievement::where('csa_form_id', session('csa_form_id'))->get();
        if($achievement==null){
            return view('student_side\csa-form\csa-page3', [
                'achievement' => new Achievement(),
            ]);   
        }
        else{
            $achievement_name = Achievement::select('achievement')->where('csa_form_id', session('csa_form_id'))->get();
            return view('student_side\csa-form\csa-page3', [
                'achievement_name' => $achievement_name,
            ]);
        }
        
    }

    public function show_insertPage4(){
        $user = Auth::user();
        $student = $user->student;
        $major_id = $student->major_id;
        $partner = Partner::where('major_id', $major_id)->get();
        $choice = Choice::where('csa_form_id', session('csa_form_id'))->get();
        if($choice == null){
            return view('student_side\csa-form\csa-page4', [
            'choice' => new Choice(),
            'partner'=>$partner,
            ]);
        }
        else{
            return view('student_side\csa-form\csa-page4', [
                'partner'=>$partner,
            ]);
        }
    }

    public function afterInsertPage4(){
        return redirect(route('student.csa-form.csa-page5'));
    }

    public function insertPage5(){
        $emergency = Emergency::where('csa_form_id', session('csa_form_id'))->first();
        if($emergency == null){
            return view('student_side\csa-form\csa-page5', [
                'emergency' => new Emergency(),
            ]);
        }
        else
        {
            return view('student_side\csa-form\csa-page5', [
                'emergency' => $emergency,
            ]);
        }
    }
    public function afterInsertPage5(Request $request){
        $emergency = Emergency::where('csa_form_id', session('csa_form_id'))->first();
        if($emergency == null){
            $emergency = new Emergency();
            $emergency->csa_form_id = session('csa_form_id');
            $emergency->name = $request->name;
            $emergency->gender = 'F';
            $emergency->relationship = $request->relationship;
            $emergency->address = $request->address;
            $emergency->mobile = $request->mobilenum;
            $emergency->telp_num = $request->telp_num;
            $emergency->email = $request->email;

        }
        else{
            $emergency->name = $request->name;
            $emergency->relationship = $request->relationship;
            $emergency->address = $request->address;
            $emergency->mobile = $request->mobilenum;
            $emergency->telp_num = $request->telp_num;
            $emergency->email = $request->email;
        }

        $emergency->save();

        return redirect(route('student.csa-form.csa-page6'));
    }

    public function insertPage6(){
        $condition = Condition::where('csa_form_id', session('csa_form_id'))->first();
        if($condition == null){
            return view('student_side\csa-form\csa-page6', [
                'condition' => new Condition(),
            ]);
        }
        else{
            return view('student_side\csa-form\csa-page6', [
                'condition' => $condition,
            ]);
        }
    }
    public function afterInsertPage6(Request $request){
        $condition = Condition::where('csa_form_id', session('csa_form_id'))->first();
        if($condition == null){
            $condition = new Condition();
            $condition->csa_form_id = session('csa_form_id');
            $condition->med_condition = $request->med_condition;
            $condition->allergy = $request->allergy;
            $condition->special_diet = $request->special_diet;
            $condition->convicted_crime = $request->convicted_crime;
            $condition->future_diffs = $request->future_diffs;
            $condition->reasons = $request->explanation;
        }
        else{
            $condition->med_condition = $request->med_condition;
            $condition->allergy = $request->allergy;
            $condition->special_diet = $request->special_diet;
            $condition->convicted_crime = $request->convicted_crime;
            $condition->future_diffs = $request->future_diffs;
            $condition->reasons = $request->explanation;
        }

        $condition->save();

        return redirect(route('student.csa-form.csa-page7'));
    }

    public function insertPage7(){
        return view('student_side\csa-form\csa-page7', [
        ]);
    }
    public function afterInsertPage7(){
        $csa_form = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first();
        $csa_form->is_submitted = true ;
        $csa_form->save();

        session()->forget(['csa_form_yearly_student_id', 'csa_form_id']);
        return redirect(route('student.home'));
    }
}
