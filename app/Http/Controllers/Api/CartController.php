<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Creuset\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        \Cart::associate(Product::class)->add([
                  'id'    => $product->id,
                  'qty'   => $request->quantity,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
                  ]);
    }
}
