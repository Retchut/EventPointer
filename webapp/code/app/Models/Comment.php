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

    public function user()
    {
        return $this->belongsTo('App/Event_Role', 'idrole');
    }}