<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function invite(Request $request, $event_id, $user_id)
    {
        // $invite = new invite();
        // $role = Event_Role::where('ishost', false)->where('eventid', $event_id)->where('userid', Auth::user()->id)->get()->first();
        // $invite->role_id = $role->id;
        // $invite->messagec = $request->invite_message;
        // if($request->get('file') != null){
        //     $invite->photo = $request->get('file');
        // }
        // $invite->save();

        return redirect()->route('event.show', ['event_id' => $event_id]);
    }
    
    public function delete($user_id, $invite_id)
    {
        $invite = Invite::find($invite_id);
        $invite->delete();

        return redirect()->route('user.show', $user_id);
    }

}
