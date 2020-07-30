<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Personal_Information extends model
{
    // custom primary key, not auto-incrementing,
    protected $primaryKey = 'csa_form_id';
    public $incrementing = false;

    protected $table = 'personal_informations';
    protected $guarded = ['csa_form_id'];

    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}