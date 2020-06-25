<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $guarded = ['user_id'];

    // THIS ONE IS WEIRD
    protected $table = 'staffs';
    
    // Relationships
    // Inverse has one relationship
    public function user(){
        return $this->belongsTo('App\User');
    }
}
