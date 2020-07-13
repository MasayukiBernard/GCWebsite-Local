<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Yearly_Student extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected $guarded = ['nim', 'academic_year_id', 'is_nominated'];

    protected $table = 'yearly_students';

    protected $attributes = ['is_nominated' => false];

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes to stated attributes
    protected static $logAttributes = ['nim', 'academic_year_id', 'is_nominated'];

    // Customize log name
    protected static $logName = 'yearly_student_log';
    
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
        static::deleting(function($yearly_student){
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

            $csa_form = $yearly_student->csa_form;
            if($csa_form != null){
                $test = $csa_form->english_test;
                if($test != null){
                    log($user, $test, $log);
                    $csa_form->english_test()->delete();
                }
                
                $info = $csa_form->academic_info;
                if($info){
                    log($user, $info, $log);
                    $csa_form->academic_info()->delete();
                }
                
                $passport = $csa_form->passport; 
                if($passport){
                    log($user, $passport, $log);
                    $csa_form->passport()->delete();   
                }
                
                $emergency = $csa_form->emergency; 
                if($emergency != null){
                    log($user, $emergency, $log);
                    $csa_form->emergency()->delete();
                }
                
                $condition = $csa_form->condition;
                if($condition != null){
                    log($user, $condition, $log);
                    $csa_form->condition()->delete();
                }

                $achievements = $csa_form->achievements;
                if($achievements != null){
                    foreach($achievements as $achievement){
                        log($user, $achievement, $log);
                    }
                    $csa_form->achievements()->delete();
                }

                $choices = $csa_form->choices;
                if($choices != null){
                    foreach($choices as $choice){
                        log($user, $choice, $log);
                    }
                    $csa_form->choices()->delete();
                }

                $yearly_student->csa_form()->delete();
                log($user, $csa_form, $log);
            }
        });
    }

    // Relationships
    // Inverse has many relationships
    public function academic_year(){
        return $this->belongsTo('App\Academic_Year', 'academic_year_id');
    }
    public function student(){
        return $this->belongsTo('App\Student', 'nim');
    }
    // Has one relationship
    public function csa_form(){
        return $this->hasOne('App\CSA_Form', 'yearly_student_id');
    }
}
