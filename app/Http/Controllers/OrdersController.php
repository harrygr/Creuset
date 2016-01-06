<?php

namespace Creuset\Http\Controllers;

use Auth;
use Creuset\Address;
use Creuset\Billing\GatewayInterface;
use Creuset\Events\OrderWasCreated;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreateOrderRequest;
use Creuset\Http\Requests\Order\ViewOrderRequest;
use Creuset\Order;
use Creuset\Repositories\User\DbUserRepository;
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
        $customer = $request->get('customer');

        if (\Auth::guest() or !$request->has('billing_address_id')) {
            $billing_address_id = $customer->addAddress(new Address($request->get('billing_address')))->id;
            $shipping_address_id = $billing_address_id;
            if (!$request->has('shipping_same_as_billing')) {
                $shipping_address_id = $customer->addAddress(new Address($request->get('shipping_address')))->id;
            }
        } else {
            $billing_address_id = $request->get('billing_address_id');
            $shipping_address_id = $request->get('shipping_address_id');
        }

        // create new order with the cart contents
        $order = Order::createFromCart($customer, [
                                       'billing_address_id' => $billing_address_id, 
                                       'shipping_address_id' => $shipping_address_id,
                                       ]);

        event(new OrderWasCreated($order));
        
        $request->session()->put('order', $order);
        return redirect()->route('checkout.pay');

    }

    public function completed(Request $request) 
    {
        $order = Order::findOrFail($request->session()->get('order_id'));

        return view('shop.order_completed')->with([
            'order' => $order,
            ]);
    }

    public function show(ViewOrderRequest $request, Order $order)
    {
        return view('orders.show', compact('order'));
    }

}
