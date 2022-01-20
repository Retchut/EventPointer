<?php

namespace App\Http\Controllers;

use App\Models\{Event};
use App\Models\{User};
use Illuminate\Console\Scheduling\Event as SchedulingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditEventController extends Controller
{
   // protected $redirectTo = 'event';


   public function show($event_id)
   {
     $events = Event::find($event_id);
     // $this->authorize('show', $events);
     return view('pages.editevent', ['event' => $events]);
   }

    public function index($event_id)
    {
        //$events = Event::find($event_id);
        //$user = User::find(Auth::user()->id);
        //$event_role = User::events_host($user->$id);
        //if(Auth::check() and this)
        return view('pages.editevent'/*, ['event' => $events]*/);
    }
/*
    public function create(Request $request)
    {
        $event = DB::transaction(function () use ($request) {
            $event = new Event();
            $this->authorize('create', $invite);
            $event->name = $request->input('name');
            $event->startDate = $request->input('startDate');
            $event->endDate = $request->input('endDate');
            $event->place = $request->input('place');
            $event->duration = $request->input('duration');
            $event->isPrivate = $request->input('isPrivate');
            $event->save();

            return $event;
        });
      }
*/
    /*public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $this->authorize('update', $event);

        if($request->input('name') != null) {
            $this->validate(request(), ['name' => 'string|max:255',]);
            $event->name = $request->input('name');
        }

        if($request->input('startDate') != null)
            $event->startDate = $request->input('startDate');

        if($request->input('endDate') != null)
            $event->endDate = $request->input('endDate');

        if($request->input('place') != null) {
            $this->validate(request(), ['place' => 'string|max:255',]);
            $event->place = $request->input('place');
        }

        if($request->input('duration') != null)
            $event->endDate = $request->input('duration');

        if($request->input('isPrivate') != null)
            $event->endDate = $request->input('isPrivate');

        $event->save();

        return redirect()-> route('event.show', $id);
    }*/
    /*
    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        $event->eventname = $request->input('eventname');
        $event->startdate = $request->input('startdate');
        $event->enddate = $request->input('enddate');
        $event->place = $request->input('place');
        $event->eventstate =$request->input('eventstate');
        $event->save();
        return redirect()-> route('event.show', $id);

    } */

    public function update(Request $request, $event_id)
    {

        $event = Event::find($request->event_id);


        if ($request->eventname != null)
            $event->eventname = $request->eventname;
        
        if ($request->event_description != null)
            $event->event_description = $request->event_description;

        if ($request->place != null)
            $event->place = $request->place;


        if ($request->startdate != null)
            $event->startdate = $request->startdate;


        if ($request->enddate != null)
            $event->enddate = $request->enddate;

        if ($request->eventstate != null)
            $event->eventstate = $request->eventstate;

        if ($request->isprivate != null)
            $event->isprivate = $request->isprivate;
    
        $event->save();

        return redirect()-> route('event.show', $event_id);
    }
}