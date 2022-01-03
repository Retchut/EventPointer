<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    public $timestamps  = false;


    protected $fillable = [
        'eventname', 'startdate', 'enddate', 'place','duration','state','isprivate'
    ];

    
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

    protected $attributes = [
        'isprivate' => false,
    ];
}
