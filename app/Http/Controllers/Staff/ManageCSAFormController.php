<?php

namespace App\Http\Controllers\Staff;

use App\Academic_Year;
use App\Choice;
use App\CSA_Form;
use App\Http\Controllers\Controller;
use App\Major;
use App\Notifications\CSAFormNominated;
use App\Yearly_Student;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ManageCSAFormController extends Controller
{
    public function show_page(){
        $success = $failed = null;
        if(session('success_notif') != null){
            $success = session('success_notif');
        }
        else if (session('failed_notif') != null){
            $failed = session('failed_notif');
        }
        session()->forget(['success_notif', 'failed_notif']);

        return view('staff_side\csa_application_forms\initial-view', [
            'academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get(),
            'majors' => Major::orderBy('name')->get(),
            'success' => $success,
            'failed' => $failed
        ]);
    }
    
    public function show_CSAForms($academic_year_id, $major_id){
        $academic_year = Academic_Year::where('id', $academic_year_id)->first();
        $major = Major::where('id', $major_id)->first();

        if($academic_year != null && $major != null){
            session()->forget('last_viewed_csa_forms_list');
            session()->put('last_viewed_csa_forms_list', ['academic_year_id' => $academic_year->id, 'major_id' => $major->id]);
            $students_nim_by_major = DB::table('students')
                                        ->select('nim')
                                        ->where('latest_deleted_at', null)->where('major_id', $major_id)
                                        ->get();
            $yearly_students = Yearly_Student::where('academic_year_id', $academic_year_id)->whereIn('nim', Arr::pluck($students_nim_by_major,'nim'))->orderBy('is_nominated')->get();
            $success = $failed = null;
            if(session('success_notif') != null){
                $success = session('success_notif');
            }
            else if (session('failed_notif') != null){
                $failed = session('failed_notif');
            }
            session()->forget(['success_notif', 'failed_notif']);
        
            if($yearly_students->first() != null){
                return view('staff_side\csa_application_forms\view', [
                    'yearly_students' => $yearly_students,
                    'academic_year' => $academic_year,
                    'major' => $major,
                    'success' => $success,
                    'failed' => $failed
                ]);
            }

            session()->put('failed_notif', 'Cannot access CSA Application Form page yet, please create at least 1 yearly student in the selected academic year and major!');
        }
        else{
            session()->put('failed_notif', 'CSA Application Form feature is not yet available, please create at least 1 record of major and academic year!');
        }
        return redirect(route('staff.csa-forms.page'));
    }

    public function get_sortedCSAForms($academic_year_id, $major_id, $field, $sort_type){
        $available_fields = array('nim', 'name', 'form_status', 'created_at', 'nomination_status');
        $sort_types = array('a' => 'asc', 'd' => 'desc');

        if(is_numeric($academic_year_id) && is_numeric($major_id) && in_array($field, $available_fields) && Arr::exists($sort_types, $sort_type)){
            $csa_forms = DB::table('csa_forms')
                            ->join('yearly_students', 'csa_forms.yearly_student_id', '=', 'yearly_students.id')
                            ->join('students', 'yearly_students.nim', '=', 'students.nim') 
                            ->join('users', 'students.user_id', '=', 'users.id')
                            ->select('csa_forms.id as id', 'students.nim as nim', 'users.name as name', 'csa_forms.is_submitted as form_status', 'csa_forms.latest_created_at as created_at', 'yearly_students.is_nominated as nomination_status')
                            ->where('yearly_students.latest_deleted_at', null)->where('students.latest_deleted_at', null)->where('users.latest_deleted_at', null)->where('yearly_students.academic_year_id', $academic_year_id)->where('students.major_id', $major_id)
                            ->orderBy($field, $sort_types[$sort_type])
                            ->get();
            
            if($csa_forms->first() != null){
                return response()->json([
                    'csa_forms' => $csa_forms,
                    'failed' => false
                ]);
            }
        }

        return response()->json([
            'failed' => true
        ]);
    }

    public function show_detailsPage($csa_form_id){
        $csa_form = CSA_Form::where('id', $csa_form_id)->first();
        if($csa_form != null){
            $profile_picture = $passport = $gpa_trans = $english = false;

            $profile_picture = Storage::disk('private')->exists($csa_form->yearly_student->student->picture_path);
            
            if($csa_form->passport != null){
                $passport = Storage::disk('private')->exists($csa_form->passport->pass_proof_path);
            }
            if($csa_form->academic_info != null){
                $gpa_trans = Storage::disk('private')->exists($csa_form->academic_info->gpa_proof_path);
            }
            if($csa_form->english_test != null){
                $english = Storage::disk('private')->exists($csa_form->english_test->proof_path);
            }
            $achievements = array('0', '0', '0');

            if($csa_form->achievements != null){
                $i = 0;
                foreach($csa_form->achievements as $achievement){
                    if(Storage::disk('private')->exists($achievement->proof_path)){
                        $achievements[$i++] = filemtime(storage_path('app\private\\' . $achievement->proof_path));
                    }
                }
            }

            return view('staff_side\csa_application_forms\details', [
                'csa_form' => $csa_form,
                'pp_last_modified' => $profile_picture == true ? filemtime(storage_path('app\private\\' . $csa_form->yearly_student->student->picture_path)) : '0',
                'filemtimes' => [
                    'passport' => $passport == true ? filemtime(storage_path('app\private\\' . $csa_form->passport->pass_proof_path)) : '0',
                    'gpa_trans' => $gpa_trans == true ? filemtime(storage_path('app\private\\' . $csa_form->academic_info->gpa_proof_path)) : '0',
                    'english' => $english == true ? filemtime(storage_path('app\private\\' . $csa_form->english_test->proof_path)) : '0',
                    'achievements' => $achievements
                ]
            ]);
        }
        abort(404);
    }

    public function confirm_nomination($csa_form_id, $choice_id){
        $csa_form = CSA_Form::where('id', $csa_form_id)->first();
        if($csa_form != null){
            $choice = Choice::where('id', $choice_id)->first();
            if($choice != null){
                session()->put('nomination_details', ['csa_form_id' => $csa_form_id, 'choice_id' => $choice_id]);
                return response()->json([
                    'nim_name' => $csa_form->yearly_student->student->nim . ' - ' . $csa_form->yearly_student->student->user->name,
                    'academic_year' => $csa_form->yearly_student->academic_year->starting_year . '/' . $csa_form->yearly_student->academic_year->ending_year . ' - ' . ($csa_form->yearly_student->academic_year->odd_semester ? "Odd" : "Even"),
                    'partner_name' => $choice->yearly_partner->partner->name,
                    'failed' => false,
                ]);
            }
        }
        return response()->json(['failed' => true]);
    }

    public function nominate(){
        $nomination_details = session('nomination_details');
        $csa_form = CSA_Form::where('id', $nomination_details['csa_form_id'])->first();
        $choice = Choice::where('id', $nomination_details['choice_id'])->first();
        if($csa_form != null && $choice != null){
            $choice->nominated_to_this = true;
            $choice->save();
            $csa_form->yearly_student->is_nominated = true;
            $csa_form->yearly_student->save();

            $yearly_student = $csa_form->yearly_student;
            // Email notification
            $yearly_student->student->user->notify(new CSAFormNominated($yearly_student->academic_year, $choice->yearly_partner->partner));
            session()->put('success_notif', 'You have successfuly NOMINATED 1 student! An email has also been sent to the student.');
        }
        else{
            session()->put('failed_notif', 'Failed to nominate 1 student!');
        }
        session()->forget('nomination_details');
        $last_list = session('last_viewed_csa_forms_list');

        if($last_list['academic_year_id'] == null || $last_list['major_id'] == null){
            return redirect(route('staff.csa_forms.page'));
        }
        return redirect('staff/csa-forms/academic-year/' . $last_list['academic_year_id'] . '/major/' . $last_list['major_id']);
    }

    public function cancel_nomination($csa_form_id){
        $csa_form = CSA_Form::where('id', $csa_form_id)->first();
        $choices = Choice::where('csa_form_id', $csa_form_id)->get();
        $yearly_student = Yearly_Student::where('id', $csa_form->yearly_student_id)->first();
        if($csa_form != null && $choices != null && $yearly_student != null){
            foreach($choices as $choice){
                $choice->nominated_to_this = false;
                $choice->save();
            }
            $yearly_student->is_nominated = false;
            $yearly_student->save();
            session()->put('success_notif', 'You have successfuly CANCELED the nomination of 1 student!');
        }
        else{
            session()->put('failed_notif', 'Failed to cancel the nonination of 1 student!');
        }
        $last_list = session('last_viewed_csa_forms_list');

        if($last_list['academic_year_id'] == null || $last_list['major_id'] == null){
            return redirect(route('staff.csa_forms.page'));
        }
        return redirect('staff/csa-forms/academic-year/' . $last_list['academic_year_id'] . '/major/' . $last_list['major_id']);
    }
}