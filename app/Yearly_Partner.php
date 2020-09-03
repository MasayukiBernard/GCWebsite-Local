<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Yearly_Partner extends Model
{
     use SoftDeletes;
     use LogsActivity;
    
     // not to use the convention table 'CSA_Forms'
     protected $table = 'yearly_partners';

     protected $guarded = ['academic_year_id', 'partner_id'];

          // Custom timestamps field name
     const CREATED_AT = 'latest_created_at';
     const UPDATED_AT = 'latest_updated_at';

     // Custom soft delete field name
     const DELETED_AT = 'latest_deleted_at';

     // Log changes to stated attributes
     protected static $logAttributes = ['id', 'academic_year_id', 'partner_id', 'quota'];

     // Customize log name
     protected static $logName = 'yearly_partner_log';

     // Log only changed attributes
     protected static $logOnlyDirty = true;

     // function for custom defining custom attributes
     public function tapActivity(Activity $activity, string $eventName)
     {
          if(strcmp($eventName, 'created') == 0 || strcmp($eventName, 'deleted') == 0){
               $activity->properties = null;
          }
     }

     public static function booted(){
          // Events Listeners
          // Delete related models
          static::deleting(function($yearly_partner){
               function log($user, $model, $desc){
                    activity()
                        ->causedBy($user)
                        ->performedOn($model)
                        ->tap(function(Activity $activity) {
                            $activity->log_name = 'cascaded_log';
                            $activity->properties = null;
                         })
                        ->log($desc);
                }
                
                $user = Auth::user();
                $log = 'deleted';
    
               $choices = $yearly_partner->choices;
               if($choices != null){
                   foreach($choices as $choice){
                         if($choice->nominated_to_this){
                              DB::table('yearly_students')
                                   ->where('id', $choice->csa_form->yearly_student->id)
                                   ->update(['is_nominated' => false, 'latest_updated_at' => date('Y-m-d H:i:s',time())]);
                              log($user, $choice->csa_form->yearly_student, 'updated');
                         }
                         log($user, $choice, $log);
                   }
                   $yearly_partner->choices()->delete();
               }
          });
     }
     
     // Relationships
     // Inverse has many relationships
     public function academic_year(){
          return $this->belongsTo('App\Academic_Year', 'academic_year_id');
     }
     
     public function partner(){
          return $this->belongsTo('App\Partner');
     }

     // Has Many Relationship
     public function choices(){
          return $this->hasMany('App\Choice', 'yearly_partner_id');
     }
}
