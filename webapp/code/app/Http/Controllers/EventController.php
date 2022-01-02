<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
      $this->authorize('show', $event);
      return view('pages.event', ['event' => $event]);
    }

    public function delete(Request $request, $event_id)
    {
      $event = Event::find($event_id);

      $this->authorize('delete', $event);
      $event->delete();

      return $event;
    }
}
