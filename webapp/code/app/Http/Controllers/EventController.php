<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use App\Models\Event_Role;
use App\Models\Comment;
use App\Models\Poll;
use App\Models\PollOption;
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
    if ($event == null)
      abort(404);
    $announcements = $event->announcements($event_id);
    $comments = $event->comments($event_id);
    $polls = $event->polls($event_id);
    $participants = $event->participants($event_id);
    $hosts = $event->hosts($event_id);
    $tag = $event->tag($event_id);
    $current_role = Event_Role::where('eventid', $event_id)->where('userid', Auth::user()->id)->get()->first();
    /* 403 exception apge*/
    /*
    $this->authorize('show', $event);
    return view('pages.event', ['event' => $event, 'reported' => False, 'comments' => $comments, 'announcements' => $announcements, 'hosts' => $hosts, 'participants' => $participants]);
    */

    if (Auth::check())
      return view('pages.event', ['event' => $event, 'current_role' => $current_role, 'reported' => $request->reported, 'comments' => $comments, 'polls' => $polls, 'announcements' => $announcements, 'hosts' => $hosts, 'participants' => $participants, 'tag' => $tag]);
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


  public function leave($event_id)
  {
    $role = Event_Role::where('ishost', false)->where('eventid', $event_id)->where('userid', Auth::user()->id)->get()->first();
    if ($role != null)
      $role->delete();

    return redirect()->route('browse.search');
  }

  public function join($event_id)
  {
    $event_role = new Event_Role;

    $event_role->userid = Auth::user()->id;
    $event_role->eventid = $event_id;
    $event_role->ishost = false;
    $event_role->save();

    return redirect()->route('event.show', $event_id);
  }


  public function cancel($event_id)
  {
    $event = Event::find($event_id);
    $event->eventstate = 'Canceled';
    $event->save();

    return redirect()->route('event.show', $event->id);
  }


  //TODO
  public function showAdd(Request $request, $event_id)
  {
    $event = Event::find($event_id);


    if ($request->search_query == "Null") {
      $user_query = User::all();
    } else {
      $user_query = User::where('username', 'ilike', '%' . $request->search_query . '%');
    }
    $users = $user_query->get();


    return view('pages.addparticipants', ['users' => $users, 'event' => $event]);
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
    $event->pictureurl = $request->pictureurl;

    $today = today()->format('Y-m-d');

    if ($event->startdate < $today)
      return view('pages.createeventerror');

    try {
      $event->save();
    } catch (\Illuminate\Database\QueryException $e) {
      return view('pages.createeventerror');
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

    return redirect()->route('event.show', $event->id);
  }

  public static function poll_author($poll_id)
  {
    $poll = Poll::find($poll_id);
    $role = Event_Role::find($poll->role_id);
    $user = User::find($role->userid);
    return $user;
  }

  public static function comment_author($comment_id)
  {
    $comment = Comment::find($comment_id);
    $role = Event_Role::find($comment->role_id);
    $user = User::find($role->userid);
    return $user;
  }


  public static function announcement_author($announcement_id)
  {
    $announcement = Announcement::find($announcement_id);
    $role = Event_Role::find($announcement->role_id);
    $user = User::find($role->userid);
    return $user;
  }

  public function showRemove($event_id)
  {
    $event = Event::find($event_id);
    $participants = $event->participants($event_id);
    return view('pages.removeparticipants', ['event' => $event, 'participants' => $participants]);
  }

  public function remove($event_id, $user_id)
  {
    $role = Event_Role::where('ishost', false)->where('eventid', $event_id)->where('userid', $user_id)->get()->first();
    $role->delete();
    return redirect()->route('event.removeparticipants', $event_id);
  }

  public function add($event_id, $user_id)
  {
    $role = new Event_Role;
    $role->userid = $user_id;
    $role->ishost = false;
    $role->eventid = $event_id;
    try {
      $role->save();
    } catch (\Illuminate\Database\QueryException $e) {
      return abort(403, "Duplicate found");
    }
    return redirect()->route('event.showaddparticipants', $event_id);
  }
}
