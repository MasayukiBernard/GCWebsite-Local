<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class English_Test extends Model
{
    // custom primary key, not auto-incrementing, 
    protected $primaryKey = 'csa_form_id';
    public $incrementing = false;

    // not to use the convention table
    protected $table = 'english_tests';

    protected $guarded = ['csa_form_id', 'proof_path'];

    // Relationships
    // Inverse has one relationship
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}
