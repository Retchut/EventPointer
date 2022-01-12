<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Event;
use App\Models\Event_Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class EventPolicy
{
    use HandlesAuthorization;

    public function show()
    {

        if (Auth::check())
            return true;
        else
            return false;
    }


    public function create(User $user)
    {
        return Auth::check();
    }


    public function list(User $user)
    {
        return Auth::check();
    }

    public function update(User $user, Event $event, Event_Role $event_role)
    {
        return $user->id == $event_role->userid  and $event_role->eventid == $event->id and $event_role->ishost;
    }
}
