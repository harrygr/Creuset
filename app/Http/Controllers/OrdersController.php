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
        $this->middleware('order.customer', ['only' => ['store']]);
    }

    /**
     * Create a new order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // take payment
        # assume payment worked

        // create new order with the cart contents
        $order = Order::createFromCart($request->get('customer'));


        // reduce stock of products
        // empty cart
        // email user
        
        return $order->load('order_items');
    }

    
}
