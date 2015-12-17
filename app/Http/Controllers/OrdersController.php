<?php

namespace Creuset\Http\Controllers;

use Auth;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Order;
use Creuset\Repositories\User\DbUserRepository;
use Creuset\User;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    private $users;

    public function __construct(DbUserRepository $users)
    {
        $this->users = $users;
    }


    /**
     * Create a new order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // create or retrieve account
            // First determine if the user is logged in
            if (Auth::check()) {
                $user = Auth::user();
            } elseif ($user = User::where('email', $request->email)->first()) {
                // Use middleware for this!!!
                // dd($request->email
                \Session::put('url.intended', 'checkout');
                return redirect()->route('auth.login', ['email' => $request->email])->with([
                    'alert' => 'This email has an account here. Please login. If you do not know your password please reset it.',
                    'alert-class' => 'warning',
                    ]);
            } else {
                // create a new user from full sign up details including password
            }

        // take payment
        # assume payment worked
        # 
        // Queue the following:
        // create new order with the cart contents
        $order = Order::createFromCart($user);

        // reduce stock of products
        // email user
    }
   
}
