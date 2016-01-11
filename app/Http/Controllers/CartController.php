<?php

namespace Creuset\Http\Controllers;

use Cart;
use Creuset\Http\Requests\AddToCartRequest;
use Creuset\Product;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

class CartController extends Controller
{
    /**
     * Show a list of the cart contents
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Cart::count()) {
            return view('shop.cart_empty');
        }

        return view('shop.cart');
    }

    /**
     * Put an item in the cart.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(AddToCartRequest $request)
    {
        $product = Product::findOrFail($request->product_id);
        $qty = (int) $request->quantity;

        Cart::associate('Product', 'Creuset')->add([
                  'id'    => $product->id,
                  'qty'   => $qty,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
                  ]);

        $cart_link = '<strong><a href="/cart">View Cart</a></strong>';

        return redirect()->back()->with([
          'alert'       => new HtmlString(sprintf('%d %s added to cart. %s', $qty, str_plural($product->name, $qty), $cart_link)),
          'alert-class' => 'success',
          ]);
    }

    /**
     * Remove an item from the cart.
     *
     * @param Request $request
     * @param string  $rowid   The row id to remove
     *
     * @return \Illuminate\Http\Response
     */
    public function remove(Request $request, $rowid)
    {
        $product = Cart::get($rowid)->product;

        Cart::remove($rowid);

        return redirect()->route('cart')->with([
          'alert'       => "{$product->name} removed from cart",
          'alert-class' => 'success',
          ]);
    }
}
