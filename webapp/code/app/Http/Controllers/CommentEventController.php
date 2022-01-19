<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Event_Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentEventController extends Controller
{
    // protected $redirectTo = 'event';


    public function index($event_id)
    {
        //$events = Event::find($event_id);
        //$user = User::find(Auth::user()->id);
        //$event_role = User::events_host($user->$id);
        //if(Auth::check() and this)
        return view('pages.commentevent', ['event_id' => $event_id]);
    }

    public function comment(Request $request, $event_id)
    {
        $comment = new Comment;
        $role = Event_Role::where('ishost', false)->where('eventid', $event_id)->where('userid', Auth::user()->id)->get()->first();
        $comment->role_id = $role->id;
        $comment->messagec = $request->comment_message;
        $comment->save();

        return redirect()->route('event.show', ['event_id' => $event_id]);
    }
}






// reported true
// botao
