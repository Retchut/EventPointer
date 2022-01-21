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


        return view('pages.inviteusers', ['users' => $users, 'event' => $event]);
    }

    public function delete($user_id, $invite_id)
    {
        $invite = Invite::find($invite_id);
        $invite->delete();

        return redirect()->route('user.show', $user_id);
    }
}
