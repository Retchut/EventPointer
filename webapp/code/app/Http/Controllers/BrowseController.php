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
  public function show()
  {
    $events = Event::all();
    // $this->authorize('show', $events);
    return view('pages.browse', ['events' => $events]);
  }
  

  public function sort($order)
  {
    $events = Event::all();
    $events_sd_asc = array();
    switch ($order) {
      case "sdate-asc":
        $events_sorted = $events->sortBy(['startdate', 'asc']);
          break;
      case "sdate-desc":
          $events_sorted = $events->sortBy(['startdate', 'desc']);
          break;
      case "edate-asc":
          $events_sorted = $events->sortBy(['enddate', 'asc']);
          break;
      case "edate-desc":
          $events_sorted = $events->sortBy(['enddate', 'desc']);
          break;
      case "dur-asc":
          $events_sorted = $events->sortBy(['duration', 'asc']);
          break;
      case "dur-desc":
          $events_sorted = $events->sortBy(['duration', 'desc']);
          break;
    }

    $scheduled = $events->sortBy(['duration', 'desc']);
    // $this->authorize('show', $events);
    return view('pages.browse', ['events' => $events_sorted]);
  }

  
}
