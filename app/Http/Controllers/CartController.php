<?php

namespace Creuset\Http\Controllers;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        \Cart::associate('Product', 'Creuset')->add([
                  'id'    => $product->id,
                  'qty'   => $request->quantity,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
                  ]);
        return redirect()->back();
    }
}
