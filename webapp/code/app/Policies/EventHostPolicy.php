<?php

namespace App\Policies;

use App\User;
use App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EventHostPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Event $event)
    {
        return true;
    }

    
    public function create(User $user)
    {
        return Auth::check();
    }


    public function list(User $user)
    {
        return Auth::check();
    }

    public function delete(User $user, Event $event)
    {
        return $user->id == $event->user_id;
    }
}