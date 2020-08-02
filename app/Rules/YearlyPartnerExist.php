<?php

namespace App\Rules;

use App\Yearly_Student;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

// A rule to prevent CSAApplicationDetails to input unallowed yearly partners
class YearlyPartnerExist implements Rule{
    private $input;
    
    public function __construct($input){
        $this->input = $input;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value){
        $academic_year_id = Yearly_Student::where('id', session('csa_form_yearly_student_id'))->first()->academic_year_id;
        $yp = DB::table('yearly_partners')
                            ->join('partners', 'partners.id', '=', 'yearly_partners.partner_id')
                            ->where('yearly_partners.latest_deleted_at', null)->where('partners.major_id', Auth::user()->student->major->id)
                            ->where('yearly_partners.academic_year_id', $academic_year_id)
                            ->where('yearly_partners.id', request($this->input))
                            ->select('yearly_partners.id')
                            ->first();
        
        return ($yp != null);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(){
        return 'Please select the preferred university from the provided list!';
    }
}
