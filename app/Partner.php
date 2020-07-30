<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Partner extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected $guarded = ['major_id'];

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes to stated attributes
    protected static $logAttributes = ['major_id', 'name', 'location', 'short_detail', 'min_gpa', 'eng_requirement'];

    // Customize log name
    protected static $logName = 'partner_log';

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
        static::deleting(function($partner){
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

            $yearly_partners = $partner->yearly_partners; 
            if($yearly_partners != null){
                foreach($yearly_partners as $yearly_partner){
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
                    log($user, $yearly_partner, $log);
                }
                $partner->yearly_partners()->delete();
            }
        });
    }

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
