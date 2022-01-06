<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EditUserController extends Controller
{
    protected $redirectTo = 'user';


    public function index($user_id)
    {
        $user = User::find($user_id);
        return view('pages.useredit', ['user' => $user]);
    }

    public function update(Request $request, $user_id)
    {
        $user = User::find($user_id);

        $this->authorize('update', $user);

        User::where('id', $user_id)->update(
            [
                'username' => $request->name,
                'email' => $request->address,
                'password' => bcrypt($request->password),
                'profilepictureurl' => $request->profilePictureUrl,
            ]
            );
    
        $user->save();

        return redirect()-> route('user.show', $user_id);
    }

}