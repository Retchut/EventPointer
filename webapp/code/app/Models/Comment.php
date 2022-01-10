<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'event_comment';


    protected $fillable = [
        'message'
    ];


    /* TODO  add commment author to event page*/
    public function user($event_id)
    {
        $user = Event_Role::where('eventid', $event_id)->join('event_comment', 'event_role.userid', '=', 'event_comment.role_id')->get();
        return $user;
    }

}