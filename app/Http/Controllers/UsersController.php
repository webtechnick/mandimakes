<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Traits\Flashes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    use Flashes;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        return view('users.account')->with([
            'user' => Auth::user()
        ]);
    }

    /**
     * Update the user
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->all())->save();

        $this->goodFlash('Your Account has been updated.');
        return back();
    }

    public function password()
    {
        return view('users.password');
    }

    public function change_password(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        $this->goodFlash('Password has been updated.');

        return back();
    }
}
