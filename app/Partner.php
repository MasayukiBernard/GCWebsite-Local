<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    protected $guarded = ['major_id'];

    // Relationships
    // Inverse has many relationship
    public function major(){
        return $this->belongsTo('App\Major');
    }
    // Has many relationship
    public function yearly_partners(){
        return $this->hasMany('App\Yearly_Partner');
    }
}
