<?php

namespace App\Http\Controllers;

use App\Address;
use App\Events\OrderWasCreated;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\Order\ViewOrderRequest;
use App\Http\Requests\SetShippingMethodRequest;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('order.customer', ['only' => ['store']]);
        $this->middleware('order.session', ['only' => ['shipping', 'pay']]);
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

        $order->syncWithCart();

        event(new OrderWasCreated($order));

        // replace the order in the session with the updated version
        $request->session()->put('order', $order->fresh());

        return redirect()->route('checkout.shipping');
    }

    /**
     * Add a shipping to an order.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function shipping(SetShippingMethodRequest $request)
    {
        $order = $request->session()->get('order');

        $order = $order->setShipping($request->get('shipping_method_id'));

        $request->session()->put('order', $order->fresh());

        return redirect()->route('checkout.pay');
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
            abort(Response::HTTP_BAD_REQUEST);
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

        $customer->addresses()->save($billing_address);

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

            $customer->addresses()->save($shipping_address);

            $addresses['shipping_address_id'] = $shipping_address->id;
        }

        return $addresses;
    }
}
