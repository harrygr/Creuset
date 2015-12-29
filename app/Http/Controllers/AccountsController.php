<?php

namespace Creuset\Http\Controllers;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
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

    public function show(Request $request)
    {
        return view('accounts.show')->with([
                                           'user' => $this->user,
                                           ]);
    }
}
