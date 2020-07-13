<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Student extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    // custom primary key, not integer, not auto-incrementing, 
    protected $primaryKey = 'nim';

    public $incrementing = false;

    protected $keyType = 'string';

    protected $guarded = ['nim', 'user_id', 'major_id', 'picture_path', 'id_card_picture_path', 'flazz_card_picture_path', 'binusian_year'];
    
    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';
    
    // Log changes to stated attributes
    protected static $logAttributes = ['major_id', 'place_birth', 'date_birth', 'nationality', 'address', 'picture_path', 'id_card_picture_path', 'flazz_card_picture_path', 'binusian_year'];

    // Customize log name
    protected static $logName = 'student_log';

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
    public function major(){
        return $this->belongsTo('App\Major');
    }

    // Has many relations
    public function yearly_students(){
        return $this->hasMany('App\Yearly_Student', 'nim');
   }
}
