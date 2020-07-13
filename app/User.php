<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    use SoftDeletes;
    use LogsActivity;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'password', 'name', 'gender', 'email', 'mobile', 'telp_num'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Default attribute value
    protected $attributes = ['is_staff' => false];
    
    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';


    // Log changes only to unguarded attributes
    protected static $logFillable = true;

    // Customize log name
    protected static $logName = 'user_log';

    // Log only changed attributes
    protected static $logOnlyDirty = true;

    // function for custom defining custom attributes
    public function tapActivity(Activity $activity, string $eventName)
    {
        if(strcmp($eventName, 'created') == 0 || strcmp($eventName, 'deleted') == 0){
            $activity->properties = null;
        }

        $user_type = 'student';
        if(Auth::user()->is_staff){
            $user_type = 'staff';
        }
        $activity->log_name = 'user:' . $user_type . '_log';
    }

    public static function booted(){
        // Events Listeners
        // Delete related models
        static::deleting(function($user){
            if($user->is_staff){
                $user->staff()->delete();
            }
            else{
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

                $yearly_students = $user->student->yearly_students;
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
                    $user->student->yearly_students()->delete();
                }
            }
    
        });
    }

    // Relationships
    // Has one relationships
    public function student(){
        if (!($this->is_staff)){
            return $this->hasOne('App\Student');
        }
        else{
            abort(404);
        }
    }
    public function staff(){
        if($this->is_staff){
            return $this->hasOne('App\Staff');
        }else{
            abort(404);
        }
    }
}
