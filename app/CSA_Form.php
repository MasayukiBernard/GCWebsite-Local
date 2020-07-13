<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class CSA_Form extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    // not to use the convention table 'CSA_Forms'
    protected $table = 'csa_forms';

    protected $guarded = ['yearly_student_id', 'is_submitted'];

    protected $attributes = ['is_submitted' => false];
    
    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes only on stated attributes
    protected static $logAttributes = ['is_submitted'];

    // Customize log name
    protected static $logName = 'csa_form_log';

    // Log only changed attributes
    protected static $logOnlyDirty = true;

    
    // function for custom defining custom attributes
    public function tapActivity(Activity $activity, string $eventName)
    {
        if(strcmp($eventName, 'created') == 0 || strcmp($eventName, 'deleted') == 0){
            $activity->properties = null;
        }
    }

    // Relationships
    // Inverse has one relationship
    public function yearly_student(){
        return $this->belongsTo('App\Yearly_Student', 'yearly_student_id');
    }

    // Has one relationships
    public function english_test(){
        return $this->hasOne('App\English_Test', 'csa_form_id');
    }

    public function academic_info(){
        return $this->hasOne('App\Academic_Info', 'csa_form_id');
    }

    public function passport(){
        return $this->hasOne('App\Passport', 'csa_form_id');
    }

    public function emergency(){
        return $this->hasOne('App\Emergency', 'csa_form_id');
    }

    public function condition(){
        return $this->hasOne('App\Condition', 'csa_form_id');
    }

    // Has many relationships
    public function achievements(){
        return $this->hasMany('App\Achievement', 'csa_form_id');
    }
    
    public function choices(){
        return $this->hasMany('App\Choice', 'csa_form_id');
    }
}
