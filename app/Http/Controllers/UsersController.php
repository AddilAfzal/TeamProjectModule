<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index')->with('users', $users)->with('title', 'Users');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.create')->with('roles', User::$valid_roles)->with('title', 'Create User');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = ['inputUserUsername' => 'The username has already been taken.'];
        $this->validate($request,
            [
                'inputUserName' => 'required|max:255',
                'inputUserUsername' => 'required|max:255|unique:users,username',
                'inputPassword' => 'required|min:6|confirmed',
                'selectRole' => 'required|user_role',
            ], $messages
        );

        User::create([
            'name' => $request['inputUserName'],
            'username' => $request['inputUserUsername'],
            'role' => $request['selectRole'],
            'password' => bcrypt($request['inputPassword']),
        ]);
        return redirect(auth()->user()->role . '/users/')->with('message', ['User Account Created', "The user account for {$request['inputUserName']} was successfully created!"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = \App\User::find($id);
        return view(auth()->user()->role . '.users.show')->with('user', $user)->with('title', 'Show User');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request,
            [
                'user_id' => 'exists:users,id'
            ]);

        $user = \App\User::find($request->user_id);
        $tmp = $user->name;

        if ($user->role == 'admin' && \App\User::where('role', 'admin')->count() == 1) {
            return redirect(auth()->user()->role . '/users/' . $user->id)->with('message', ['Failed', "Account belonging to '{$tmp}' cannot be deleted. Cannot delete the only admin account."]);
        } else {
            if (count($user->blanks) != 0) {
                return redirect(auth()->user()->role . '/users/' . $user->id)->with('message', ['Failed', "Account belonging to '{$tmp}' cannot be deleted. This user is currently assigned at least one blank. Please remove the association before continuing, or consider suspending the account."]);
            } else {
                \App\User::destroy($request->user_id);
            }
        }


        return redirect(auth()->user()->role . '/users/')->with('message', ['User Deletion Successful', "Account belonging to '{$tmp}' was deleted."]);
    }

    public function resetPassword(Request $request)
    {
        $this->validate($request,
            [
                'user_id' => 'exists:users,id'
            ]);

        $user = \App\User::find($request->user_id);
        $tmp = str_random(8);
        $user->password = bcrypt($tmp);
        $user->save();

        return redirect(auth()->user()->role . '/users/' . $user->id)->with('message', ['Password Reset Successful', "The new password is: {$tmp} "]);
    }

    public function search(Request $request)
    {
        $users = \App\User::where('name', 'LIKE', "%{$request->name}%")->get();
        return view(auth()->user()->role . '.users.search')
            ->with('users', $users)
            ->with('message', count($users) . " result" . ((count($users) != 1) ? "s" : "") . " found matching '" . $request->name . "'")
            ->with('title', 'Search Users');
    }

    public function suspend(Request $request)
    {
        $this->validate($request,
            [
                'user_id' => 'exists:users,id'
            ]);

        $user = \App\User::find($request->user_id);
        if ($user->role == 'admin' && \App\User::where('role', 'admin')->count() == 1) {
            return redirect(auth()->user()->role . '/users/' . $user->id)->with('message', ['Failed', "Account belonging to '{$user->name}' cannot be suspended. Cannot suspend the only admin account."]);
        } else {
            $user->suspend();
            return redirect(auth()->user()->role . '/users/' . $user->id)->with('message', ['Account Suspension Successful', "The account has been suspended."]);
        }
    }

    public function activate(Request $request)
    {
        $this->validate($request,
            [
                'user_id' => 'exists:users,id'
            ]);

        $user = \App\User::find($request->user_id);

        if($user->isSuspended == true) {
            $user->activate();
            return redirect(auth()->user()->role . '/users/' . $user->id)->with('message', ['Account Activation Successful', "The account has been reactivated."]);
        } else {
            return redirect(auth()->user()->role . '/users/' . $user->id)->with('message', ['Failed', "Account belonging to '{$user->name}' cannot be activated. The account is already active."]);
        }
    }
}
