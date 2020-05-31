<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Passport extends Model
{
    // custom primary key, not auto-incrementing, 
    protected $primaryKey = 'csa_form_id';
    public $incrementing = false;

    protected $guarded = ['csa_form_id'];

    // Relationship
    // Inver has one relationship
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}
