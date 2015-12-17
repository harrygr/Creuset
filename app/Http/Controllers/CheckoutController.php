<?php

namespace Creuset\Http\Controllers;

use Illuminate\Http\Request;

use Cart;
use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;

class CheckoutController extends Controller
{
    /**
     * Show the checkout page
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if (!Cart::count()) {
            return view('shop.cart_empty');
        }
        return view('shop.checkout');
    }

    
}
