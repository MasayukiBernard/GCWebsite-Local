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
use App\Http\Requests\CSAAchievement;
use App\Http\Requests\CSAApplicationDetails;
use App\Http\Requests\CSACondition;
use App\Http\Requests\CSAEmergency;
use App\Http\Requests\CSAPassport;
use App\Notifications\CSAFormCreated;
use App\Notifications\CSAFormSubmitted;
use App\Passport;
use App\Yearly_Student;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ManageCSAFormController extends Controller
{
    private function mail_notifyCSAFormCreation($yearly_student_id){
        $user = Auth::user();
        dispatch(function() use(&$user, &$yearly_student_id){
            $user->notify(new CSAFormCreated($user->student->yearly_students()->where('id', $yearly_student_id)->first()->academic_year));
        });
    }

    private function mail_notifyCSAFormSubmission($yearly_student_id){
        $user = Auth::user();
        dispatch(function() use(&$user, &$yearly_student_id){
            $user->notify(new CSAFormSubmitted($user->student->yearly_students()->where('id', $yearly_student_id)->first()->academic_year));  
        });
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

            $csa_form = CSA_Form::where('yearly_student_id' , $yearly_student->id)->first();
            if($csa_form != null){
                session()->put('csa_form_id', $csa_form->id);
            }

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

            session()->put('csa_form_id', $csa_form->id);
            
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
        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        if(session('failed_notif') != null){
            $failed = session('failed_notif');
        }

        session()->forget(['success_notif', 'failed_notif']);
        $csa_form = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first();

        $major = $csa_form->yearly_student->student->major->name;
        $academic_info = Academic_Info::where('csa_form_id', $csa_form->id)->first();
        $english_test = English_Test::where('csa_form_id', $csa_form->id)->first();

        $gpa = $academic_info != null ? Storage::disk('private')->exists($academic_info->gpa_proof_path) : false;
        $e_test = $english_test != null ? Storage::disk('private')->exists($english_test->proof_path) : false;

        return view('student_side\csa-form\csa-page2', [
            'success' => $success,
            'failed' => $failed,
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
            $english_test->proof_path = Storage::disk('private')->putFile('students/english_tests/' . (Arr::exists($validatedData, 'test-type') ? $test_types[$validatedData['test-type']] : 'Other'), $validatedData['proof-path']);
        }

        $english_test->score = $validatedData['score'];
        $english_test->test_date = $validatedData['test-date'];

        $english_test->save();

        return redirect(route('student.csa-form.csa-page2a'));
    }

    public function show_insertPage2a(){
        $passport = Passport::where('csa_form_id', session('csa_form_id'))->first(); 

        $pass_proof = $passport != null ? Storage::disk('private')->exists($passport->pass_proof_path) : false;

        return view('student_side\csa-form\csa-page2a',[
            'passport' => $passport != null ? $passport : null,
            'ysid' => session('csa_form_yearly_student_id'),
            'filemtime' => $pass_proof ? filemtime(storage_path('app\private\\' . $passport->pass_proof_path)) : '0'
        ]);
    }

    public function page2a_insert(CSAPassport $request){
        // if no passport record
            // Creates passport record
        // else
            // display, existing db data along with images

        $validatedData = $request->validated();

        $passport = Passport::where('csa_form_id', session('csa_form_id'))->first();

        if($passport == null){
            $passport = new Passport();
            $passport->csa_form_id = session('csa_form_id');
            $passport->latest_updated_at = null;
        }

        $passport->pass_num = $validatedData['pass-num'];
        $passport->pass_expiry = $request['pass-expiry'];

        if(Arr::exists($validatedData, 'pass-proof-path')){
            if($passport->pass_proof_path != null){
                Storage::disk('private')->move($passport->pass_proof_path, 'students/trashed/passports/' . Str::afterLast($passport->pass_proof_path, '/'));
            }
            $passport->pass_proof_path = Storage::disk('private')->putFile('students/passports' , $validatedData['pass-proof-path']);
        }

        $passport->save();

        return redirect(route('student.csa-form.csa-page3'));
    }

    public function show_insertPage3(){
        // SHOW EXISTING ACHIVEMENT IMAGE
        $achievements = Achievement::where('csa_form_id', session('csa_form_id'))->orderBy('latest_created_at')->get();
        if($achievements == null){
            return view('student_side\csa-form\csa-page3');   
        }
        else{
            $filemtimes = array('0', '0', '0');
            $proof_ids = array(0, 0, 0);
            $i = 0;
            foreach($achievements as $ac){
                if(Storage::disk('private')->exists($ac->proof_path)){
                    $proof_ids[$i] = $ac->id;
                    $filemtimes[$i++] = filemtime(storage_path('app\private\\' . $ac->proof_path));
                }
            }

            $success = null;
            if(session('success_notif') != null){
                $success = session('success_notif');
            }

            return view('student_side\csa-form\csa-page3', [
                'success' => $success,
                'achievements' => $achievements,
                'ysid' => session('csa_form_yearly_student_id'),
                'filemtimes' => $filemtimes,
                'proof_ids' => $proof_ids
            ]);
        }
    }

    public function delete_achievement(Request $request){
        $validatedData = $request->validate([
            'id' => ['required', 'integer', 'min:1', 'exists:achievements,id']
        ]);

        $achievement = Achievement::where('id', $request['id'])->first();

        if(strcmp($achievement->csa_form->yearly_student->nim, Auth::user()->student->nim) == 0){
            Storage::disk('private')->move($achievement->proof_path, 'students/trashed/achievements/' . Str::afterLast($achievement->proof_path, '/'));
            $achievement->delete();
            
            session()->put('success_notif', 'You have succesfuly deleted an uploaded achievement!');
            return redirect(route('student.csa-form.csa-page3'));
        }

        abort(403);
    }

    public function page3_insert(CSAAchievement $request){
        // if no Achievements record
            // Creates Achievements record
        // else
            // display, existing db record along with proof image
        
        $validatedData = $request->validated();

        $achievements = Achievement::where('csa_form_id', session('csa_form_id'))->orderBy('latest_created_at')->get();

        for($i = 0; $i < 3; ++$i){
            if($validatedData['name-' . $i] != null){
                // NEED TO COMPARE FIRST WHETHER EXISTING ACHIEVEMENT AVAILABLE
                // MIGHT NEED TO CHANGE THE REQUEST RULES

                if(isset($achievements[$i])){
                    $achievements[$i]->achievement = $validatedData['name-' . $i];
                    $achievements[$i]->year = $validatedData['year-' . $i];
                    $achievements[$i]->institution = $validatedData['institution-' . $i];
                    $achievements[$i]->other_details = $validatedData['other-details-' . $i];

                    if(Arr::exists($validatedData, 'proof-path-' . $i)){
                        if($achievements[$i]->proof_path != null){
                            Storage::disk('private')->move($achievements[$i]->proof_path, 'students/trashed/achievements/' . Str::afterLast($achievements[$i]->proof_path, '/'));
                        }
                        $achievements[$i]->proof_path = Storage::disk('private')->putFile('students/achievements', $validatedData['proof-path-'. $i]);
                    }

                    $achievements[$i]->save();
                }
                else{
                    $achievement = new Achievement();
                    $achievement->csa_form_id = session('csa_form_id');
                    $achievement->latest_updated_at = null;

                    $achievement->achievement = $validatedData['name-' . $i];
                    $achievement->year = $validatedData['year-' . $i];
                    $achievement->institution = $validatedData['institution-' . $i];
                    $achievement->other_details = $validatedData['other-details-' . $i];

                    $achievement->proof_path = Storage::disk('private')->putFile('students/achievements', $validatedData['proof-path-'. $i]);

                    $achievement->save();
                }
            }
        }
        
        return redirect(route('student.csa-form.csa-page4'));
    }

    public function show_insertPage4(){
        $major_id = Auth::user()->student->major->id;
        $academic_info = Academic_Info::where('csa_form_id', session('csa_form_id'))->first();
        
        if($academic_info == null){
            session()->put('failed_notif', 'Please fill in your academic information before proceeding to application details!');
            return redirect(route('student.csa-form.csa-page2'));
        }

        $academic_year_id = Yearly_Student::where('id', session('csa_form_yearly_student_id'))->first()->academic_year->id;

        $yp_in_mjay = DB::table('yearly_partners')
                            ->join('partners', 'yearly_partners.partner_id', '=', 'partners.id')
                            ->join('majors', 'partners.major_id', '=', 'majors.id')
                            ->where('yearly_partners.latest_deleted_at', null)->where('yearly_partners.academic_year_id', $academic_year_id)
                            ->where('partners.min_gpa', '<=', $academic_info->gpa)->where('majors.id', $major_id)
                            ->select('yearly_partners.id', 'partners.name', 'partners.location')
                            ->get();
        
        $choices = Choice::where('csa_form_id', session('csa_form_id'))->orderBy('latest_created_at')->get();

        return view('student_side\csa-form\csa-page4', [
            'yp_in_mjay' => $yp_in_mjay,
            'academic_year_id' => $academic_year_id,
            'choices' => $choices != null ? $choices : null
        ]);
    }

    public function page4_insert(CSAApplicationDetails $request){
        // if no choice record
            // Creates choice record
        // else
            // display, existing db record

        $validatedData = $request->validated();

        $choices = Choice::where('csa_form_id', session('csa_form_id'))->orderBy('latest_created_at')->get();
        for($i = 0; $i < 3; ++$i){
            if($validatedData['preferred-uni-' . $i] != null){
                if(isset($choices[$i])){
                    $choices[$i]->yearly_partner_id = $validatedData['preferred-uni-' . $i];
                    $choices[$i]->motivation = $validatedData['motivation-' . $i];

                    $choices[$i]->save();
                }
                else{
                    $choice = new Choice();
                    $choice->csa_form_id = session('csa_form_id');
                    $choice->latest_updated_at = null;
                    $choice->yearly_partner_id = $validatedData['preferred-uni-' . $i];
                    $choice->motivation = $validatedData['motivation-' . $i];

                    $choice->save();
                }
            }
        }
        
        return redirect(route('student.csa-form.csa-page5'));
    }

    public function show_insertPage5(){
        $emergency = Emergency::where('csa_form_id', session('csa_form_id'))->first();
        
        return view('student_side\csa-form\csa-page5', [
            'emergency' => $emergency
        ]);
    }

    public function page5_insert(CSAEmergency $request){
        $validatedData = $request->validated();
        
        $emergency = Emergency::where('csa_form_id', session('csa_form_id'))->first();

        if($emergency == null){
            $emergency = new Emergency();
            $emergency->csa_form_id = session('csa_form_id');
            $emergency->latest_updated_at = null;
        }
        
        $emergency->gender = $validatedData['gender'];
        $emergency->name = $validatedData['name'];
        $emergency->relationship = $validatedData['relationship'];
        $emergency->address = $validatedData['address'];
        $emergency->mobile = $validatedData['mobile'];
        $emergency->telp_num = $validatedData['telp-num'];
        $emergency->email = $validatedData['email'];

        $emergency->save();

        return redirect(route('student.csa-form.csa-page6'));
    }

    public function show_insertPage6(){
        $condition = Condition::where('csa_form_id', session('csa_form_id'))->first();
        return view('student_side\csa-form\csa-page6', [
            'condition' => $condition,
        ]);
    }
    public function page6_insert(CSACondition $request){
        $validatedData = $request->validated();

        $condition = Condition::where('csa_form_id', session('csa_form_id'))->first();
        if($condition == null){
            $condition = new Condition();
            $condition->csa_form_id = session('csa_form_id');
            $condition->latest_updated_at = null;
        }

        $condition->med_condition = $validatedData['med-condition'];
        $condition->allergy = $validatedData['allergy'];
        $condition->special_diet = $validatedData['special-diet'];
        $condition->convicted_crime = $validatedData['convicted-crime'];
        $condition->future_diffs = $validatedData['future-diffs'];
        $condition->reasons = $validatedData['explanation'];

        $condition->save();

        return redirect(route('student.csa-form.csa-page7'));
    }

    public function show_insertPage7(){
        $academic_info = Academic_Info::where('csa_form_id', session('csa_form_id'))->first();
        $passport = Passport::where('csa_form_id', session('csa_form_id'))->first();
        $achievements = Achievement::where('csa_form_id', session('csa_form_id'))->get();
        $choices = Choice::where('csa_form_id', session('csa_form_id'))->get();
        $emergency = Emergency::where('csa_form_id', session('csa_form_id'))->first();
        $condition = Condition::where('csa_form_id', session('csa_form_id'))->first();

        $form_submitted = CSA_Form::where('id', session('csa_form_id'))->first()->is_submitted;
        $allow_submit = false;
        if($academic_info != null && $passport != null && $choices->first() != null 
                && $emergency != null && $condition != null){
            $allow_submit = true;
        }

        return view('student_side\csa-form\csa-page7',[
            'form_submitted' => $form_submitted,
            'allow_submit' => $allow_submit
        ]);
    }

    public function page7_insert(Request $request){
        $validatedData = $request->validate([
            'agree' => ['required']
        ]);

        $csa_form = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first();
        if(!($csa_form->is_submitted)){
            $csa_form->is_submitted = true;
            $csa_form->save();

            $this->mail_notifyCSAFormSubmission(session('csa_form_yearly_student_id'));
        }

        return redirect(route('student.csa-form.summary'));
    }

    public function show_summaryPage(){
        $student = Auth::user()->student;
        $csa_form = CSA_Form::where('yearly_student_id', session('csa_form_yearly_student_id'))->first();
        $achievements = $csa_form->achievements;

        $pp_path = Storage::disk('private')->exists($student->picture_path);
        $ic_path = Storage::disk('private')->exists($student->id_card_picture_path);
        $fc_path = Storage::disk('private')->exists($student->flazz_card_picture_path);
        $pass_path = Storage::disk('private')->exists($csa_form->passport->pass_proof_path);
        $gpa_path = Storage::disk('private')->exists($csa_form->passport->pass_proof_path);
        $et_path = Storage::disk('private')->exists($csa_form->english_test->proof_path);
        $ac_path = array(
            isset($achievements[0]) ? Storage::disk('private')->exists($achievements[0]->proof_path) : false,
            isset($achievements[1]) ? Storage::disk('private')->exists($achievements[1]->proof_path) : false,
            isset($achievements[2]) ? Storage::disk('private')->exists($achievements[2]->proof_path) : false,
        );

        return view('student_side\csa-form\summary',[
            'csa_form' => $csa_form,
            'student' => $csa_form->yearly_student->student,
            'academic_year' => $csa_form->yearly_student->academic_year,
            'ysid' => $csa_form->yearly_student->id,
            'filemtimes' => array(
                'pp' => $pp_path == true ? filemtime(storage_path('app\private\\' . $student->picture_path)) : '0',
                'ic' => $ic_path == true ? filemtime(storage_path('app\private\\' . $student->id_card_picture_path)) : '0',
                'fc' => $fc_path == true ? filemtime(storage_path('app\private\\' . $student->flazz_card_picture_path)) : '0',
                'gpa_trans' => $gpa_path == true ? filemtime(storage_path('app\private\\' . $csa_form->academic_info->gpa_proof_path)) : '0',
                'passport' => $pass_path == true ? filemtime(storage_path('app\private\\' . $csa_form->passport->pass_proof_path)) : '0',
                'english_test' => $et_path == true ? filemtime(storage_path('app\private\\' . $csa_form->english_test->proof_path)) : '0',
                'achievements' => array(
                    $ac_path[0] == true ? filemtime(storage_path('app\private\\' . $achievements[0]->proof_path)) : '0',
                    $ac_path[1] == true ? filemtime(storage_path('app\private\\' . $achievements[1]->proof_path)) : '0',
                    $ac_path[2] == true ? filemtime(storage_path('app\private\\' . $achievements[2]->proof_path)) : '0',
                )
            ),
        ]);
    }
}
