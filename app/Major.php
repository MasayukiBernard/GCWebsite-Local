<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Major extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected $fillable = ['name'];

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes to all fillable attributes
    protected static $logFillable = true;
    
    // Customize log name
    protected static $logName = 'major_log';
    
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
        static::deleting(function($major){
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

            $students = $major->students;
            if($students != null){
                foreach($students as $student){
                    $yearly_students = $student->yearly_students;
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
                        $student->yearly_students()->delete();
                    }
                    
                    log($user, $student->user, $log);
                    $student->user()->delete();

                    log($user, $student, $log);
                }
                $major->students()->delete();
            }

            $partners = $major->partners;
            if($partners != null){
                foreach($partners as $partner){
                    $yearly_partners = $partner->yearly_partners; 
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
                        $partner->yearly_partners()->delete();
                    }
                    log($user, $partner, $log);
                }
                $major->partners()->delete();
            }
        });
    }

    // Relationships
    // Has many relationships
    public function students(){
        return $this->hasMany('App\Student');
    }

    public function partners(){
        return $this->hasMany('App\Partner');
    }
}
