<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $guarded = ['csa_form_id'];

    // Relationships
    // Inverse has many relationship
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}
