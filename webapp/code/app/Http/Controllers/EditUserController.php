<?php

namespace App\Http\Controllers;

use App\{User};

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditUserController extends Controller
{
    protected $redirectTo = 'user';


    public function index($user_id)
    {
        $user = User::find($user_id);
        return view('pages.editUser', ['user' => $user]);
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        $this->authorize('update', $user);

        if($request->input('username') != null) {
            $this->validate(request(), ['username' => 'string|max:255',]);
            $user->name = $request->input('username');
        }

        if($request->input('email') != null) {
            $this->validate(request(), ['email' => 'string|email|max:255',]);
            $user->email = $request->input('email');
        }

        if($request->input('password') != null){
            $this->validate(request(), ['password' => 'string|min:8',]);
            $user->password = bcrypt($request->input('password'));
        }

        if($request->input('profilePictureUrl') != null){
            $this->validate(request(), ['profilePictureUrl' => 'string|min:8',]);
            $user->password = bcrypt($request->input('profilePictureUrl'));
        }

        $user->save();

        return redirect()-> route('user.show', $user_id);
    }

}