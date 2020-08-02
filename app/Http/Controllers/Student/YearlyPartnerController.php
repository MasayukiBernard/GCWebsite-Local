<?php

namespace App\Http\Controllers\Student;

use App\Academic_Year;
use App\Http\Controllers\Controller;
use App\Yearly_Partner;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class YearlyPartnerController extends Controller{
    public function show_initialView(){
        session()->forget(['csa_form_id', 'csa_form_yearly_student_id']);
        
        $academic_years = DB::table('yearly_students')
                            ->select('academic_years.*')
                            ->where('yearly_students.latest_deleted_at', null)->where('nim', Auth::user()->student->nim)
                            ->join('academic_years', 'academic_years.id', '=', 'yearly_students.academic_year_id')
                            ->get();

        return view('student_side\yearly_partner\initial-view',[
            'academic_years' => $academic_years
        ]);
    }

    public function show_page($academic_year_id){
        $student = Auth::user()->student;
        $yearly_student = $student->yearly_students()->where('academic_year_id', $academic_year_id)->first();
    
        if($yearly_student == null){
            abort(403);
        }

        $academic_year = Academic_Year::where('id', $academic_year_id)->first();
        $partners = DB::table('partners')
                            ->join('yearly_partners', 'yearly_partners.partner_id', '=', 'partners.id')
                            ->where('yearly_partners.latest_deleted_at', null)->where('partners.major_id', $student->major->id)
                            ->where('yearly_partners.academic_year_id', $academic_year->id)
                            ->orderBy('location')
                            ->select('partners.*')
                            ->get();
                            
        return view('student_side\yearly_partner\see-yearly-partners', [
            'academic_year' => $academic_year,
            'major_name' => $student->major->name,
            'partners' => $partners
        ]);
    }
}