<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'event_poll';


    protected $fillable = [
        'message'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Event_Role', 'idrole');
    }

    public function pollOptions($poll_id)
    {
        $pollOptions = PollOption::where('pollId', $poll_id)->join('event_poll', 'pollId', '=', 'event_poll.role_id')->get()->unique();
        return $pollOptions;
    }
}
