<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Emergency extends Model
{
    // custom primary key, not auto-incrementing, 
    protected $primaryKey = 'csa_form_id';
    public $incrementing = false;

    // to not use convention table name 'emergencys'
    protected $table = 'emergencies';
    protected $guarded = ['csa_form_id'];
    
    // one to one relationship (inverse)
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}
