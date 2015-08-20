<?php

namespace Creuset\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Creuset\Http\Requests\UpdateUserRequest;
use Creuset\Http\Controllers\Controller;
use Creuset\User;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function profile()
	{
		return $this->edit(auth()->user());
	}

    public function edit(User $user)
    {   
        $roles = \Creuset\Role::lists('display_name', 'id');
    	return view('admin.users.edit')->with(compact('user', 'roles'));
    }

    public function update(User $user, UpdateUserRequest $request)
    {
    	$user->update($request->all());
    	
    	return redirect()->back()->with([
    		'alert' => 'Profile updated', 
    		'alert-class' => 'success'
    		]);
    }
}
