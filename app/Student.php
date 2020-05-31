<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    // custom primary key, not integer, not auto-incrementing, 
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $guarded = ['nim', 'user_id', 'major_id', 'picture_path', 'id_card_picture_path', 'flazz_card_picture_path', 'binusian_year'];

    // Relationships
    // Inverse has one relationship
    public function user(){
        return $this->belongsTo('App\User');
    }
    // Inverse has many relationship
    public function major(){
        return $this->belongsTo('App\Major');
    }
    // Has many relations
    public function yearly_students(){
        return $this->hasMany('App\Yearly_Student', 'nim');
   }
}
