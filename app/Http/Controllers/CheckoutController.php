<?php

namespace App\Http\Controllers;

use App\Repositories\ShippingMethod\ShippingMethodRepository;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function __construct()
    {
        $this->middleware('order.session', ['only' => ['shipping', 'pay']]);
    }

    /**
     * Show the checkout page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // In case we need to redirect to a login page
        // we'll flash the checkout as the intended url
        $request->session()->flash('url.intended', 'checkout');

        $order = $request->session()->get('order', new \App\Order());

        if (!$request->session()->has('order')) {
            $request->session()->put('order', $order);
        }

        return view('shop.checkout', compact('order'));
    }

    /**
     * Show the page for choosing a shipping method for an order.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function shipping(Request $request, ShippingMethodRepository $shipping_methods)
    {
        $order = $request->session()->get('order')->fresh();

        $shipping_methods = $shipping_methods->forCountry($order->shipping_address->country);

        if ($shipping_methods->isEmpty()) {
            return redirect()->route('checkout.show')->with([
                'alert'       => 'It looks as though we can\'t deliver to your chosen country. Please choose a different shipping address.',
                'alert-class' => 'warning',
                ]);
        }

        // If there's only one shipping method available, just skip the shipping page and set it directly
        if (count($shipping_methods) === 1) {
            $order = $order->setShipping($shipping_methods->first()->id)->fresh();

            $request->session()->put('order', $order);

            return redirect()->route('checkout.pay');
        }

        return view('shop.shipping', [
            'order'            => $order,
            'shipping_methods' => $shipping_methods,
            ]);
    }

    /**
     * Show the page for paying for an order.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        $order = $request->session()->get('order')->fresh();

        if (!$order->hasShipping()) {
            return redirect()->route('checkout.shipping')->with([
                'alert'       => 'Please select a shipping method',
                'alert-class' => 'warning',
                ]);
        }

        return view('orders.pay', ['order' => $order]);
    }
}
