<?php

namespace Creuset\Http\Controllers;

use Auth;
use Creuset\Address;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Http\Requests\CreateOrderRequest;
use Creuset\Http\Requests\Order\ViewOrderRequest;
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
    public function store(CreateOrderRequest $request)
    {
        // take payment
        # assume payment worked
        $customer = $request->get('customer');

        if (\Auth::guest()) {
            $billing_address_id = $this->saveAddress($request->get('billing_address'), $customer)->id;
            $shipping_address_id = null;
            if (!$request->has('shipping_same_as_billing')) {
                $shipping_address_id = $this->saveAddress($request->get('shipping_address'), $customer)->id;
            }
        } else {
            $billing_address_id = $request->get('billing_address_id');
            $shipping_address_id = $request->get('shipping_address_id');
        }

        // create new order with the cart contents
        $order = Order::createFromCart($customer, $billing_address_id, $shipping_address_id);

        // reduce stock of products
        // empty cart
        // email user
        
        \Session::flash('order', $order);
        return redirect()->route('orders.completed');

    }

    public function completed() {
        $order = \Session::get('order');
        return view('shop.order_completed')->with(compact('order'));
    }

    public function show(ViewOrderRequest $request, Order $order)
    {
        return view('orders.show', compact('order'));
    }

    protected function saveAddress($data, User $customer)
    {
        return $customer->addresses()->save(new Address($data));
    }
    
}
