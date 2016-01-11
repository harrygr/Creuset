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
        $request->session()->flash('url.intended', 'checkout');
        return view('shop.checkout');
    }

    /**
     * Show the page for paying for an order
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function pay(Request $request)
    {
        if (!$request->session()->has('order')) {
            abort(419);
        }
        $order = $request->session()->get('order');

        return view('orders.pay')->with(compact('order'));
    }
}
