<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Staff extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected $guarded = ['user_id'];

    // THIS ONE IS WEIRD
    protected $table = 'staffs';
    
    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes only to unguarded attributes
    protected static $logUnguarded = true;

    // Customize log name
    protected static $logName = 'staff_log';

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
    public function user(){
        return $this->belongsTo('App\User');
    }

    // Inverse has many relationship
    public function student_requests(){
        return $this->hasMany('App\Student_Request');
    }
}
