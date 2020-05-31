<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Yearly_Partner extends Model
{
     // not to use the convention table 'CSA_Forms'
     protected $table = 'yearly_partners';

     protected $guarded = ['academic_year_id', 'partner_id'];

     // Relationships
     // Inverse has many relationships
     public function academic_year(){
          return $this->belongsTo('App\Academic_Year', 'academic_year_id');
     }
     public function partner(){
          return $this->belongsTo('App\Partner');
     }
}
