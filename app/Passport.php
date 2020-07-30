<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Passport extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    // custom primary key, not auto-incrementing, 
    protected $primaryKey = 'csa_form_id';
    
    public $incrementing = false;

    protected $guarded = ['csa_form_id', 'pass_proof_path'];

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes only on stated attributes
    protected static $logAttributes = ['pass_num', 'pass_expiry', 'pass_proof_path'];
    
    // Customize log name
    protected static $logName = 'passport_log';
    
    // Log only changed attributes
    protected static $logOnlyDirty = true;

    // function for custom defining custom attributes
    public function tapActivity(Activity $activity, string $eventName)
    {
        if(strcmp($eventName, 'created') == 0 || strcmp($eventName, 'deleted') == 0){
            $activity->properties = null;
        }
    }
    
    // Relationship
    // Inver has one relationship
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
}
