<?php

namespace Creuset\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Creuset\Http\Requests\UpdateUserRequest;
use Creuset\Http\Requests\CreateUserRequest;
use Creuset\Http\Controllers\Controller;
use Creuset\User;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

    public function index()
    {
        $users = User::with('role')->get();
        return view('admin.users.index')->with(compact('users'));
    }

    /**
     * Show a form for editng the currently logged in user
     * @return Response
     */
	public function profile()
	{
		return $this->edit(auth()->user());
	}

    /**
     * Show a form for editing a user
     * @param  User   $user 
     * @return Reponse      
     */
    public function edit(User $user)
    {   
    	return view('admin.users.edit')->with(compact('user', 'roles'));
    }

    public function create(User $user)
    {
        return view('admin.users.create', compact('user', 'roles'));
    }

    public function store(CreateUserRequest $request, User $user)
    {
        $user->create($request->all());

        return redirect()->route('admin.users.index')->with([
            'alert' => 'User Created!', 
            'alert-class' => 'success'
            ]);
    }

    /**
     * Update the user in storage
     * @param  User              $user    
     * @param  UpdateUserRequest $request 
     * @return Response                     
     */
    public function update(User $user, UpdateUserRequest $request)
    {
    	$user->update($request->all());
    	
    	return redirect()->back()->with([
    		'alert' => 'Profile updated', 
    		'alert-class' => 'success'
    		]);
    }
}
