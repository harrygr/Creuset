<?php

use Creuset\Product;

trait UsesCart {
    protected function putProductInCart($product = null)
    {
        $product = $product ? $product : factory(Product::class)->create();

        \Cart::associate('Product', 'Creuset')->add([
                  'id'    => $product->id,
                  'qty'   => 1,
                  'name'  => $product->name,
                  'price' => $product->getPrice(),
        ]);
        return $product;
    }
}