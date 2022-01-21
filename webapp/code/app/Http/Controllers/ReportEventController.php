<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Models\Report;
use Illuminate\Console\Scheduling\Event as SchedulingEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportEventController extends Controller
{

    public function index($event_id)
    {

    return view('pages.reportevent', ['event_id' => $event_id]);
    }

    public function report(Request $request, $event_id){
        $report = new Report;
        $report->eventid = $event_id;
        $report->userid = Auth::user()->id;
        $report->descriptions = $request->report_message;
        $report->save();
        
        return redirect()->route('event.show', ['event_id' => $event_id, 'popup_message' => 'Event reported successfully.']);
    }


    public function delete($report_id)
  {
    $report = Report::find($report_id);

    $report->delete();

    return redirect()->route('user.show',Auth::user()->id);
  }

}