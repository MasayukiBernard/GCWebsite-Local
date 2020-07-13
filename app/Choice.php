<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Contracts\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

class Choice extends Model
{
    use SoftDeletes;
    use LogsActivity;
    
    protected $guarded = ['csa_form_id', 'yearly_partner_id', 'nominated_to_this'];

    // Default attribute value
    protected $attributes = ['nominated_to_this' => false];

    // Custom timestamps field name
    const CREATED_AT = 'latest_created_at';
    const UPDATED_AT = 'latest_updated_at';

    // Custom soft delete field name
    const DELETED_AT = 'latest_deleted_at';

    // Log changes only on unguarded attributes
    protected static $logAttributes = ['yearly_partner_id', 'motivation', 'nominated_to_this'];
    // Customize log name
    protected static $logName = 'choice_log';
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
        static::deleted(function($choice){
            if($choice->nominated_to_this){
                $csa_form = $choice->csa_form;
                $csa_form->is_nominated = false;
                $csa_form->save();
            }
        });
   }

    // Relationship
    // Inverse has many relationship
    public function csa_form(){
        return $this->belongsTo('App\CSA_Form', 'csa_form_id');
    }
    public function yearly_partner(){
        return $this->belongsTo('App\Yearly_Partner', 'yearly_partner_id');
    }
}
