<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academic_Year extends Model
{
    // not to use the convention table 'CSA_Forms'
    protected $table = 'academic_years';

    protected $guarded = [];

    // Relationships
    // Has many relationships
    public function yearly_students(){
        return $this->hasMany('App\Yearly_Student', 'academic_year_id');
    }
    public function yearly_partners(){
        return $this->hasMany('App\Yearly_Partner', 'academic_year_id');
    }
}
