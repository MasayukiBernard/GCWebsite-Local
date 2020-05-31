<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yearly_Student extends Model
{
    protected $guarded = ['nim', 'academic_year_id', 'is_nominated'];

    protected $table = 'yearly_students';

    protected $attributes = ['is_nominated' => false];
    
    // Relationships
    // Inverse has many relationships
    public function academic_year(){
        return $this->belongsTo('App\Academic_Year', 'academic_year_id');
    }
    public function student(){
        return $this->belongsTo('App\Student', 'nim');
    }
    // Has one relationship
    public function csa_form(){
        return $this->hasOne('App\CSA_Form', 'yearly_student_id');
    }
}
