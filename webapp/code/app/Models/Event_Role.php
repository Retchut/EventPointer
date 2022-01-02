<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event_Role extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'event_role';


    public function event()
    {
        return $this->belongsTo('App\Event', 'eventid');
    }

    public function member()
    {
        return $this->belongsTo('App\Member', 'memberid');
    }

    /*public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function announcements()
    {
        return $this->hasMany('App\Announcement');
    }

    public function polls()
    {
        return $this->hasMany('App\Poll');
    }
*/

    public function hosts(){
        return $this->belongsToMany('App\Event_Role', 'event_role');
    }

    /**
     * Hosts of the event
     */
    public function participants()
    {
        return $this->belongsToMany('App\User', 'ticket', 'idevent', 'iduser');
    }

}