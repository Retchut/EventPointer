<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invitation;
use Auth;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InvitationController extends Controller
{

    public function index()
    {
        return view('pages.createInvite', [
            'invite' => Invite::all(),
        ]);
    }

    public function send(Request $request){
        $users = User::where('email', $request['query'])->get();
    

        if(count($users) == 1){
            $user = $users[0];

            $candidate = DB::table('invitation')->where('event_id', '=', $request['event_id'])->where('invited_id', '=', $user->id)->get();

            if(count($candidate) == 0){
                $invitation = new Invitation;
                $invitation->invited_id = $user->id;
                $invitation->event_id = $request['event_id'];
                $invitation->message = $request['message'] ? $request['message'] : "You have been invited to this epic event!";
                $invitation->save();

                return response()->json(['invite_id' => $invitation->id, 'user_id' => $user->id, 'username' => $user->username], 200);
            }      
            else {
                Log::error('Unable to add collaborator to event with id:' . $request['event_id'] . ' - internal error (500)');
                return response()->json($user, 500);
            }

                     
        }
        Log::error('Unable to add collaborator to event with id:' . $request['event_id'] . ' - not found (404)');
        return response()->json([], 404);
    }
}