<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
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
