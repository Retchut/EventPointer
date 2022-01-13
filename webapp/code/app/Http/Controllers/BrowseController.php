<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\Event;

class BrowseController extends Controller
{
  /**
   * Shows the home page view.
   *
   * @return View
   */
  public function show(Request $request)
  {
    //search for query
    if($request->search_query == "Null"){
      $event_query=Event::all();
    }
    else{
      $event_query=Event::where('eventname', 'like', '%'.$request->search_query.'%');
    }

    //search for state
    if(!(is_null($request->event_state) || ($request->event_state == "All"))){
      $event_query->where('eventstate', $request->event_state);
    }

    //fetch data
    $events = $event_query->get();
    
    //sort
    switch ($request->sort) {
      case "sdate-asc":
        $events = $events->sortBy(['startdate', 'asc']);
          break;
      case "sdate-desc":
          $events = $events->sortBy(['startdate', 'desc']);
          break;
      case "edate-asc":
          $events = $events->sortBy(['enddate', 'asc']);
          break;
      case "edate-desc":
          $events = $events->sortBy(['enddate', 'desc']);
          break;
      case "dur-asc":
          $events = $events->sortBy(['duration', 'asc']);
          break;
      case "dur-desc":
          $events = $events->sortBy(['duration', 'desc']);
          break;
    }
    // $this->authorize('show', $events);
    return view('pages.browse', ['events' => $events]);
  }
}
