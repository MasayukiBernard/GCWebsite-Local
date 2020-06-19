<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;
    
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
