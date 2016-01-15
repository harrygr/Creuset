<?php

namespace Creuset\Http\Controllers;

use Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!Cart::count()) {
            return view('shop.cart_empty');
        }

        // In case we need to refirest to a login page
        // we'll flash the checkout as the intended url
        $request->session()->flash('url.intended', 'checkout');

        $order = $request->session()->get('order', new \Creuset\Order);
        
        if (!$request->session()->has('order')) {
            $request->session()->put('order', $order);
        }

        return view('shop.checkout', compact('order'));
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
        if (!$request->session()->has('order') or \Cart::count() === 0) {
            return view('shop.cart_empty');
        }
        $order = $request->session()->get('order')->syncWithCart()->fresh();

        return view('orders.pay', compact('order'));
    }
}
