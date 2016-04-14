<?php

use App\Product;

trait UsesCart
{
    protected function putProductInCart($product = null)
    {
        $product = $product ? $product : factory(Product::class)->create();

        \Cart::associate('Product', 'App')->add([
                  'id'    => $product->id,
                  'qty'   => 1,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
        ]);

        return $product;
    }
}
