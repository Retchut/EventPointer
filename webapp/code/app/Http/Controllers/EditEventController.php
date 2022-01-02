<?php

namespace App\Http\Controllers;

use App\{Event};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditEventController extends Controller
{
    protected $redirectTo = 'event';


    public function index($id)
    {
        $event = Event::find($id);
        return view('pages.editEvent', ['event' => $event]);
    }

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

}