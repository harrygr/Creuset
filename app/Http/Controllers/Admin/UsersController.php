<?php

namespace Creuset\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Creuset\Http\Requests;
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
		return $this->edit(auth()->user()->username);
	}

    public function edit($username)
    {
    	$user = User::where('username', $username)->first();
    	var_dump($user);
    }
}
