<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CSA_Form extends Model
{
    // not to use the convention table 'CSA_Forms'
    protected $table = 'csa_forms';

    protected $guarded = ['id','yearly_student_id', 'is_submitted'];

    protected $attributes = ['is_submitted' => false];
    
    // Relationships
    // Inverse has one relationship
    public function yearly_student(){
        return $this->belongsTo('App\Yearly_Student', 'yearly_student_id');
    }
    // Has one relationships
    public function english_test(){
        return $this->hasOne('App\English_Test', 'csa_form_id');
    }
    public function academic_info(){
        return $this->hasOne('App\Academic_Info', 'csa_form_id');
    }
    public function passport(){
        return $this->hasOne('App\Passport', 'csa_form_id');
    }
    public function emergency(){
        return $this->hasOne('App\Emergency', 'csa_form_id');
    }
    public function condition(){
        return $this->hasOne('App\Condition', 'csa_form_id');
    }
    // Has many relationships
    public function achievements(){
        return $this->hasMany('App\Achievement', 'csa_form_id');
    }
    public function choices(){
        return $this->hasMany('App\Choice', 'csa_form_id');
    }
    public function personal_info(){
        return $this->hasMany('App\Personal_Info', 'csa_form_id');
    }
}
