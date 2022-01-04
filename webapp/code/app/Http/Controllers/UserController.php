<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Event_Role;

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
      $events = $user->events();
      // $this->authorize('show', $user);
      return view('pages.user', $user, $events->get());
    }

}
