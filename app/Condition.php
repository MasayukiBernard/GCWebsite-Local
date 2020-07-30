<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Condition extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    // custom primary key, not auto-incrementing, 
    protected $primaryKey = 'csa_form_id';

    public $incrementing = false;
    
    protected $guarded = ['csa_form_id'];

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes only on unguarded attributes
    protected static $logUnguarded = true;

    // Customize log name
    protected static $logName = 'condition_log';

    // Log only changed attributes
    protected static $logOnlyDirty = true;

    // function for custom defining custom attributes
    public function tapActivity(Activity $activity, string $eventName)
    {
        if(strcmp($eventName, 'created') == 0 || strcmp($eventName, 'deleted') == 0){
            $activity->properties = null;
        }
    }
    
   // one to one relationship (inverse)
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}