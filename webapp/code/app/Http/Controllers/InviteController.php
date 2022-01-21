<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function showusers(Request $request, $event_id)
    {
        $event = Event::find($event_id);


        if ($request->search_query == "Null") {
            $user_query = User::all();
        } else {
            $user_query = User::where('username', 'ilike', '%' . $request->search_query . '%');
        }
        $users = $user_query->get();


        return view('pages.inviteuser', ['users' => $users, 'event' => $event]);
    }


    public function invite($event_id, $user_id)
    {
        $invite = new Invite;
        $invite->receiverid = $user_id;
        $receiver = User::find($user_id);
        foreach ($receiver->events_as_participant($user_id) as $event) {
            if ($event->id == $event_id)
                abort(403, "User cannot be invited");
        }
        $invite->senderid = Auth::user()->id;
        $invite->eventid = $event_id;
        try {
            $invite->save();
        } catch (\Illuminate\Database\QueryException $e) {
            return abort(403, "Duplicate found");
        }
        return redirect()->route('invite.show', $event_id);
    }

    public function delete($user_id, $invite_id)
    {
        $invite = Invite::find($invite_id);
        $invite->delete();

        return redirect()->route('user.show', $user_id);
    }
}
