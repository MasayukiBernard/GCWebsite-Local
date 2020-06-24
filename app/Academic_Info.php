<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Academic_Info extends Model
{
    // custom primary key, not auto-incrementing, 
    protected $primaryKey = 'csa_form_id';
    public $incrementing = false;

    // not to use the convention table
    protected $table = 'academic_infos';

    protected $guarded = ['csa_form_id', 'major_id', 'gpa_proof_path'];
    
    // Relationships
    // Inverse has one relationship
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}
