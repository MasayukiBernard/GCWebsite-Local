<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    protected $fillable = ['name'];

    // Relationships
    // Has many relationships
    public function students(){
        return $this->hasMany('App\Student');
    }
    public function partners(){
        return $this->hasMany('App\Partner');
    }
}
