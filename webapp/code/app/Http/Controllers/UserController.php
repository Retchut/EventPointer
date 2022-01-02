<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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
      $this->authorize('show', $user);
      return view('pages.user', ['user' => $user]);
    }
}
