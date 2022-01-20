<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Event_Role;
use App\Models\Comment;
use App\Models\Announcement;
use App\Models\User;


use Illuminate\Auth\Middleware\Authorize;

class EventController extends Controller
{
  /**
   * Shows the home page view.
   *
   * @param  int  $id
   * @return View
   */
  public function show($event_id, Request $request)
  {
    $event = Event::find($event_id);
    $announcements = $event->announcements($event_id);
    $comments = $event->comments($event_id);
    $participants = $event->participants($event_id);
    $hosts = $event->hosts($event_id);
    $tag = $event->tag($event_id);
        /* 403 exception apge*/
    /*
    $this->authorize('show', $event);
    return view('pages.event', ['event' => $event, 'reported' => False, 'comments' => $comments, 'announcements' => $announcements, 'hosts' => $hosts, 'participants' => $participants]);
    */

    if (Auth::check())
      return view('pages.event', ['event' => $event, 'reported' => $request->reported, 'comments' => $comments, 'announcements' => $announcements, 'hosts' => $hosts, 'participants' => $participants,'tag'=>$tag]);
    else
      return redirect("/login");
  }



  public function delete($event_id)
  {
    $event = Event::find($event_id);

    //$this->authorize('delete', $event);

    $event->delete();

    return redirect()->route('home');
  }

  public function cancel($event_id)
  {
      //TODO
  }

  public function addparticipant($event_id)
  {
      //TODO
  }

  public function showCreateForm()
  {
    return view('pages.createevent');
  }

  public function create(Request $request)
  {
    $event = new Event();
    $this->authorize('create', $event);

    $event->eventname = $request->eventname;
    $event->event_description = $request->event_description;
    $event->tagid = $request->tagid;
    $event->place = $request->place;
    $event->startdate = $request->get('startdate');
    $event->enddate = $request->get('enddate');
    $event->eventstate = $request->get('eventstate');
    $event->isprivate = $request->get('isprivate');

    try {
      $event->save();
    
    } catch (\Illuminate\Database\QueryException $e) {
      return redirect()->route('event.create', Auth::user()->id);
    }

    //$picture = $request->file('cover');
    //$extension = $picture->getClientOriginalExtension();
    //$path = $event->id . '.' . $extension;
    //Storage::disk('public')->put('/event/' . $path,  File::get($picture));
    //$photo = new Photo();
    //$photo->name = $path;
    //$photo->idevent = $event->id;
    //$photo->save();

    $event_role = new Event_Role;
    $event_role->userid = Auth::user()->id;
    $event_role->eventid = $event->id;
    $event_role->ishost = true;
    $event_role->save();

    return redirect()-> route('event.show', $event->id);
  }

  public static function comment_author($comment_id)
  {
      $comment = Comment::find($comment_id);
      $role =Event_Role::find($comment->role_id);
      $user = User::find($role->userid);
      return $user;
  }


  public static function announcement_author($announcement_id)
  {
      $announcement = Announcement::find($announcement_id);
      $role =Event_Role::find($announcement->role_id);
      $user = User::find($role->userid);
      return $user;
  }

}
