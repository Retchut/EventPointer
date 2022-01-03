<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{

    public function index()
    {
        return view('pages.createInvite', [
            'username' => Username::all(),
        ]);
    }

    public function create(Request $request)
    {
        $invite = DB::transaction(function () use ($request) {
            $invite = new Invite();
            $this->authorize('create', $invite);
            $invite->username = $request->input('username');
            $invite->event = $request->input('event');
            $invite->save();

            return $invite;
        });
      }
}
