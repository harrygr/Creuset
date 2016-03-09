<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\HtmlString;

class CartController extends Controller
{
    /**
     * Show a list of the cart contents.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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

        Cart::associate('Product', 'App')->add([
                  'id'    => $product->id,
                  'qty'   => $qty,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
                  ]);

        return redirect()->back()->with([
          'alert'       => new HtmlString(sprintf('%d %s added to cart. %s or %s.',
            $qty,
            str_plural($product->name, $qty),
            '<strong><a href="/checkout">Checkout</a></strong>',
            '<strong><a href="/shop">continue shopping</a></strong>'
            )),
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

        $route = Cart::count() > 0 ? 'cart' : 'products.index';

        return redirect()->route($route)->with([
          'alert'       => "{$product->name} removed from cart",
          'alert-class' => 'success',
          ]);
    }
}
