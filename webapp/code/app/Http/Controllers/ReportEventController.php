<?php

namespace App\Http\Controllers;

use App\Models\{Event};
use App\Models\{User};
use Illuminate\Console\Scheduling\Event as SchedulingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportEventController extends Controller
{
   // protected $redirectTo = 'event';


    public function index($event_id)
    {
        //$events = Event::find($event_id);
        //$user = User::find(Auth::user()->id);
        //$event_role = User::events_host($user->$id);
        //if(Auth::check() and this)
    return view('pages.reportevent'/*, ['event' => $events]*/);
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

    public function update(Request $request, $id)
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
    }
*/
}