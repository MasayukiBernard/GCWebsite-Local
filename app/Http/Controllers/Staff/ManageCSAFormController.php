<?php

namespace App\Http\Controllers\Staff;

use App\Academic_Year;
use App\Choice;
use App\CSA_Form;
use App\Http\Controllers\Controller;
use App\Major;
use App\Yearly_Student;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ManageCSAFormController extends Controller
{
    public function show_page(){
        return view('staff_side\csa_application_forms\initial-view', ['academic_years' => Academic_Year::orderBy('ending_year', 'desc')->orderBy('odd_semester')->get(), 'majors' => Major::all()]);
    }
    
    public function get_CSAForms($academic_year_id, $major_id){
        $academic_year = Academic_Year::where('id', $academic_year_id)->first();
        $major = Major::where('id', $major_id)->first();

        if($academic_year != null && $major != null){
            session()->forget('last_viewed_csa_forms_list');
            session()->put('last_viewed_csa_forms_list', ['academic_year_id' => $academic_year->id, 'major_id' => $major->id]);
            $students_nim_by_major = DB::table('students')->select('nim')->where('major_id', $major_id)->get();
            $yearly_students = Yearly_Student::where('academic_year_id', $academic_year_id)->whereIn('nim', Arr::pluck($students_nim_by_major,'nim'))->orderBy('is_nominated')->get();

            if($yearly_students->first() != null){
                return view('staff_side\csa_application_forms\view', ['yearly_students' => $yearly_students, 'academic_year' => $academic_year, 'major' => $major]);
            }
        }

        // Failed, notice yearly student not yet available
        return redirect(route('staff.csa-forms.page'));
    }

    public function show_detailsPage($csa_form_id){
        $csa_form = CSA_Form::where('id', $csa_form_id)->first();
        if($csa_form != null){
            return view('staff_side\csa_application_forms\details', ['csa_form' => $csa_form]);
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
                    'failed' => false,
                    'nim_name' => $csa_form->yearly_student->student->nim . ' - ' . $csa_form->yearly_student->student->user->name,
                    'academic_year' => $csa_form->yearly_student->academic_year->starting_year . '/' . $csa_form->yearly_student->academic_year->ending_year . ' - ' . ($csa_form->yearly_student->academic_year->odd_semester ? "Odd" : "Even"),
                    'partner_name' => $choice->yearly_partner->partner->name
                ]);
            }
        }
        return response()->json(['failed' => true]);
    }

    public function nominate(){
        $nomination_details = session('nomination_details');
        $csa_form = CSA_Form::where('id', $nomination_details['csa_form_id'])->first();
        if($csa_form != null){
            $choice = Choice::where('id', $nomination_details['choice_id'])->first();
            if($choice != null){
                $choice->nominated_to_this = true;
                $choice->save();
                $csa_form->yearly_student->is_nominated = true;
                $csa_form->yearly_student->save();
            }
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
        if($csa_form != null){
            $choices = Choice::where('csa_form_id', $csa_form_id)->get();
            $yearly_student = Yearly_Student::where('id', $csa_form->yearly_student_id)->first();
            if($choices != null && $yearly_student != null){
                foreach($choices as $choice){
                    $choice->nominated_to_this = false;
                    $choice->save();
                }
                $yearly_student->is_nominated = false;
                $yearly_student->save();
            }
        }
        $last_list = session('last_viewed_csa_forms_list');
        if($last_list['academic_year_id'] == null || $last_list['major_id'] == null){
            return redirect(route('staff.csa_forms.page'));
        }
        return redirect('staff/csa-forms/academic-year/' . $last_list['academic_year_id'] . '/major/' . $last_list['major_id']);
    }
}