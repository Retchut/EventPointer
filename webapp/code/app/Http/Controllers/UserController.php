<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Report;



class UserController extends Controller
{
  /**
   * Shows the user page.
   *
   * @param  int  $id
   * @return View
   */
  public function show($user_id)
  {
    $user = User::find($user_id);
    if (is_null($user)) {
      return abort(404);
    } else if ($user->isadmin && !Auth::user()->isadmin)
      return abort(403, "Access Denied");


    $events = $user->events($user_id);

    $reports = Report::all();

    $user_stats = [
      'Upvotes' => 0,
      'Comments' => 0,
      'Total Events' => count($events),
      'Member Since' => $user->registrationdate
    ];
    if (Auth::check())
      return view('pages.user', ['user' => $user, 'events' => $events, 'user_stats' => $user_stats, 'reports' => $reports]);
    else
      return redirect("/login");
  }

  public function delete($user_id)
  {
    $user = User::find($user_id);

    $this->authorize('delete', $user);

    Auth::logout();

    $user->username = 'deleted' . $user->id;
    $user->email = 'deleted' . $user->id . '@deleted.com';
    $user->password = bcrypt('deleted');

    $user->save();

    return redirect()->route('home');
  }
}
