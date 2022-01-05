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
  

  // public function show()
  // {
  //   $events = Event::all();
    // $events_sd_asc = Event::orderBy('startdate', 'asc')->get();
    // $events_sd_des = Event::orderBy('startdate', 'desc')->get();
    // $events_ed_asc = Event::orderBy('enddate', 'asc')->get();
    // $events_ed_des = Event::orderBy('enddate', 'desc')->get();
    // $events_dur_asc = Event::orderBy('duration', 'asc')->get();
    // $events_dur_des = Event::orderBy('duration', 'desc')->get();
    // $scheduled = Event::orderBy('duration', 'desc')->get();
    // $this->authorize('show', $events);
    // return view('pages.browse', ['events' => $events]);
    // return view('pages.browse', ['event' => $events], ['events_sd_asc' => $events_sd_asc], ['events_sd_des' => $events_sd_des], ['events_ed_asc' => $events_ed_asc], ['events_ed_des' => $events_ed_des], ['events_dur_asc' => $events_dur_asc], ['events_dur_des' => $events_dur_des], ['scheduled' => $scheduled]);
  // }

  
}
