<?php

namespace Creuset\Http\Controllers;

use Creuset\Address;
use Creuset\Events\OrderWasCreated;
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
     * Create a new order.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $customer = $request->get('customer');
        $order = $request->session()->get('order');

        $addresses = $this->processAddresses($request);

        // update the order with the correct info
        $order->billing_address_id = $addresses['billing_address_id'];
        $order->shipping_address_id = $addresses['shipping_address_id'];
        $order->user_id = $customer->id;
        $order->save();

        event(new OrderWasCreated($order));

        // replace the order in the session with the updated version
        $request->session()->put('order', $order->fresh());

        return redirect()->route('checkout.pay');
    }

    /**
     * Get the order billing and shipping address depending on what was passed in the request.
     *
     * @param Request $request
     *
     * @return array
     */
    private function processAddresses(Request $request)
    {
        if (\Auth::check() and $request->has('billing_address_id')) {
            return [
               'billing_address_id'     => $request->get('billing_address_id'),
               'shipping_address_id'    => $request->get('shipping_address_id', $request->get('billing_address_id')),
            ];
        }

        $customer = $request->get('customer');
        $order = $request->session()->get('order');

        $billing_address = $order->getAddress('billing');
        $billing_address->fill($request->get('billing_address'));
        $billing_address->user_id = $customer->id;
        $billing_address->save();

        $addresses = [
               'billing_address_id'     => $billing_address->id,
               'shipping_address_id'    => $billing_address->id,
        ];

        if ($request->has('different_shipping_address')) {

            // If the order previously had shipping same as billing but now a
            // different address is being used, we'll create a new one or
            // we'll end up updating the billing address too
            $shipping_address = $order->shippingSameAsBilling() ? new Address() : $order->getAddress('shipping');

            $shipping_address->fill($request->get('shipping_address'));
            $shipping_address->user_id = $customer->id;
            $shipping_address->save();

            $addresses['shipping_address_id'] = $shipping_address->id;
        }

        return $addresses;
    }

    /**
     * Show the page for a completed order.
     * 
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function completed(Request $request)
    {
        if (!$request->session()->has('order_id')) {
            abort(419);
        }
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
