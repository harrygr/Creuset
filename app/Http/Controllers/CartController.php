<?php

namespace Creuset\Http\Controllers;

use Cart;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Http\Requests\AddToCartRequest;
use Creuset\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
      return view('cart.index');
    }

    /**
     * Put an item in the cart
     * @param  Request $request 
     * @return Illuminate\Http\Response
     */
    public function store(AddToCartRequest $request)
    {
        $product = Product::findOrFail($request->product_id);

        Cart::associate('Product', 'Creuset')->add([
                  'id'    => $product->id,
                  'qty'   => $request->quantity,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
                  ]);
        return redirect()->back()->with([
          'alert'       => "$product->name added to cart",
          'alert-class' => "success",
          ]);
    }

    /**
     * Remove an item from the cart
     * @param  Request $request 
     * @param  string  $rowid   The row id to remove
     * @return Illuminate\Http\Response
     */
    public function remove(Request $request, $rowid)
    {
        $product = \Cart::get($rowid)->product;
        Cart::remove($rowid);
        return redirect()->back()->with([
          'alert'       => "$product->name removed from cart",
          'alert-class' => "success",
          ]);
    }
}
