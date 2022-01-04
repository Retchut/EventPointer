<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Models\Event;
use App\Models\Event_Role;

/**
 * Class User
 * @package App\Models
 *
 * @property \Illuminate\Database\Eloquent\Collection authorWork
 * @property \Illuminate\Database\Eloquent\Collection book
 * @property \Illuminate\Database\Eloquent\Collection review
 * @property \Illuminate\Database\Eloquent\Collection item
 * @property \Illuminate\Database\Eloquent\Collection Work
 * @property \Illuminate\Database\Eloquent\Collection Loan
 * @property \Illuminate\Database\Eloquent\Collection wishList
 * @property string username
 * @property string email
 * @property string pass
 * @property string profilePictureUrl
 * @property boolean isAdmin
 */
class User extends Authenticatable
{
    use Notifiable;
    public $timestamps  = false;
    protected $table = 'users';

    public $fillable = [
        'id',
        'username',
        'email',
        'pass',
        'profilePictureUrl',
        'isAdmin'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'username' => 'string',
        'email' => 'string',
        'pass' => 'string',
        'profilePictureUrl' => 'string',
        'isAdmin' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'pass', 'remember_token', 'isAdmin',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [

    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function reviews()
    {
        return $this->belongsToMany(Event::class, 'review');
    }

    /**
     * The events this user owns.
     */
    public function host() {
        return $this->hasMany('App\Models\Event_Role')->where(['host.ishost', '=', 'true'],['$this->id','=','host.userid']);
      }
  
      public function participant() {
          return $this->hasMany('App\Models\Event_Role')->where(['host.ishost', '=', 'false'],['$this->id','=','host.userid']);
      }
  
       /**
       * @return \Illuminate\Database\Eloquent\Relations\HasMany
       **/
      public function events($user_id)
      {
            $eventrole = Event_Role::all();
            // $events = array();
            // foreach($eventrole as $er){
            //     if($er->use)
            //     array_push($events, $er);
            // }
            // unset($er);
            // return Event::whereBelongsTo($user_id)->get();
            return Event::all();
      }

    /**
     * @return mixed
     */
    public function isAdmin() {
        return $this->is_admin;
    }

    protected $attributes = [
        'isadmin' => false,
    ];
}

