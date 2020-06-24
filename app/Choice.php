<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    protected $guarded = ['csa_form_id', 'yearly_partner_id', 'nominated_to_this'];

    // Default attribute value
    protected $attributes = ['nominated_to_this' => false];

    // Relationship
    // Inverse has many relationship
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
    public function yearly_partner(){
        return $this->belongsTo('App\Yearly_Partner', 'yearly_partner_id');
    }
}
