<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Member extends Authenticatable
{
    use Notifiable;

    // Don't add create and update timestamps in database.
    public $timestamps  = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'pass', 'profilepictureurl'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'email','password', 'remember_token','isadmin'
    ];

    /**
     * The cards this user owns.
     */
     public function host() {
      return $this->hasMany('App\Models\Event_Role')->where(['host.ishost', '=', 'true'],['$this->id','=','host.memberid']);
    }

    public function participant() {
        return $this->hasMany('App\Models\Event_Role')->where(['host.ishost', '=', 'false'],['$this->id','=','host.memberid']);
    }

    protected $attributes = [
        'isadmin' => false,
    ];
}