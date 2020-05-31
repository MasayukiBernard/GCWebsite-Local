<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    // custom primary key, not auto-incrementing, 
    protected $primaryKey = 'csa_form_id';
    public $incrementing = false;
    
    protected $guarded = ['csa_form_id'];

   // one to one relationship (inverse)
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}
