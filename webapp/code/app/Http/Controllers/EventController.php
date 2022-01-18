<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use Illuminate\Auth\Middleware\Authorize;

class EventController extends Controller
{
  /**
   * Shows the home page view.
   *
   * @param  int  $id
   * @return View
   */
  public function show($event_id)
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
    return view('pages.event', ['event' => $event, 'comments' => $comments, 'announcements' => $announcements, 'hosts' => $hosts, 'participants' => $participants]);
    */

    if (Auth::check())
      return view('pages.event', ['event' => $event, 'comments' => $comments, 'announcements' => $announcements, 'hosts' => $hosts, 'participants' => $participants,'tag'=>$tag]);
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

  public function index()
  {
    return view('pages.createEvent', [
      'place' => Place::all(),
      'duration' => Duration::all(),
      'name' => Name::all(),
    ]);
  }

  public function create(Request $request)
  {
    $event = DB::transaction(function () use ($request) {
      $event = new Event();
      $this->authorize('create', $event);
      $event->name = $request->input('name');
      $event->startDate = $request->input('startDate');
      $event->endDate = $request->input('endDate');
      $event->place = $request->input('place');
      $event->duration = $request->input('duration');
      $event->isPrivate = $request->input('isPrivate');
      $event->save();

      //$picture = $request->file('cover');
      //$extension = $picture->getClientOriginalExtension();
      //$path = $event->id . '.' . $extension;
      //Storage::disk('public')->put('/event/' . $path,  File::get($picture));
      //$photo = new Photo();
      //$photo->name = $path;
      //$photo->idevent = $event->id;
      //$photo->save();

      $event_host = new EventHost();
      $this->authorize('create', Auth::user());
      $event_host->iduser = Auth::user()->id;
      $event_host->idevent = $event->id;
      $event_host->save();

      return $event;
    });
  }
}
