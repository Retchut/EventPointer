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
      return view('pages.browse', ['event' => $events]);
    }
}
