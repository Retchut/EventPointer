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
      if(is_null($user)){
        return abort(404);
      }
      $events = $user->events($user_id);
      
      $reports = Report::all();
      
      $user_stats = [
        'Upvotes' => 0,
        'Comments' => 0,
        'Total Events' => count($events),
        'Member Since' => $user->registrationdate
      ];
      return view('pages.user', ['user' => $user, 'events' => $events, 'user_stats' => $user_stats,'reports'=>$reports]);
    }

    public function delete($user_id) : RedirectResponse
    {
        if(Auth::guest()) {
            return redirect()->back();
        }

        $user = User::find($user_id);

        $user->delete();

        return redirect()->url('/');
    }

}
