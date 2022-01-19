<?php

namespace App\Http\Controllers;


use App\Models\Announcement;
use App\Models\Event_Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementEventController extends Controller
{
    // protected $redirectTo = 'event';


    public function index($event_id)
    {
        //$events = Event::find($event_id);
        //$user = User::find(Auth::user()->id);
        //$event_role = User::events_host($user->$id);
        //if(Auth::check() and this)
        return view('pages.announcementevent', ['event_id' => $event_id]);
    }

    public function announcement(Request $request, $event_id)
    {
        $announcement = new Announcement;
        $role = Event_Role::where('ishost', true)->where('eventid', $event_id)->where('userid', Auth::user()->id)->get()->first();
        $announcement->role_id = $role->id;
        $announcement->messagea = $request->announcement_message;
        $announcement->save();

        return redirect()->route('event.show', ['event_id' => $event_id]);
    }
}






// reported true
// botao
