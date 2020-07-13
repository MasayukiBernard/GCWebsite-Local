<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Academic_Year extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    // not to use the convention table
    protected $table = 'academic_years';

    protected $guarded = [];

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';
    
    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes to all unguarded attributes
    protected static $logUnguarded = true;

    // Customize log name
    protected static $logName = 'academic_year_log';

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
        static::deleting(function($academic_year){
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

            $yearly_partners = $academic_year->yearly_partners; 
            if($yearly_partners != null){
                foreach($yearly_partners as $yearly_partner){
                    $choices = $yearly_partner->choices;
                    if($choices != null){
                        foreach($choices as $choice){
                            log($user, $choice, $log);
                        }
                        $yearly_partner->choices()->delete();
                    }
                    log($user, $yearly_partner, $log);
                }
                $academic_year->yearly_partners()->delete();
            }

            $yearly_students = $academic_year->yearly_students;
            if($yearly_students != null){
                foreach($yearly_students as $yearly_student){
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
                    }

                    $csa_form = $yearly_student->csa_form;
                    if($csa_form != null){
                        log($user, $csa_form, $log);
                        $yearly_student->csa_form()->delete();
                    }

                    log($user, $yearly_student, $log);
                }
                $academic_year->yearly_students()->delete();
            }
        });
    }

    // Relationships
    // Has many relationships
    public function yearly_students(){
    
        return $this->hasMany('App\Yearly_Student', 'academic_year_id');
    }
    
    public function yearly_partners(){
        return $this->hasMany('App\Yearly_Partner', 'academic_year_id');
    }
}
