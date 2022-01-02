<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Shows the admin page view.
     *
     * @param  int  $id
     * @return View
     */
    public function show($admin_id)
    {
      $admin = Admin::find($admin_id);
      $this->authorize('show', $admin);
      return view('pages.admin', ['admin' => $admin]);
    }
}
