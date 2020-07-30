<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Student_Request extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected $guarded = ['nim', 'staff_id', 'request_type', 'description', 'is_approved'];

    protected $table = 'student_requests';
    
    // Types: ['1' => 'profile-edit']

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes to stated attributes
    protected static $logAttributes = ['nim', 'staff_id', 'request_type', 'description', 'is_approved'];

    // Customize log name
    protected static $logName = 'student_request_log';

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
    // Inverse has many relationships
    public function student(){
        return $this->belongsTo('App\Student', 'nim');
    }

    public function staff(){
        return $this->belongsTo('App\Staff');
    }
}
