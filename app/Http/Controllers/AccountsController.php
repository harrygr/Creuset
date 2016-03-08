<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    private $user;

    public function __construct(Guard $auth)
    {
        $this->middleware('auth');

        $this->user = $auth->user();
    }

    /**
     * Show the page for managing the user account.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return view('accounts.show', ['user' => $this->user]);
    }

    /**
     * Show the page for editing an account.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        return view('accounts.edit', ['user' => $this->user]);
    }

    /**
     * Update the user in storage.
     *
     * @param User              $user
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->all());

        return redirect()->route('accounts.show')->with([
            'alert'       => 'Profile updated',
            'alert-class' => 'success',
            ]);
    }
}
