<?php

namespace App\Http\Controllers;

use App\Product;
use App\Term;

class ProductsController extends Controller
{
    /**
     * Display a single product page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Term $product_category, Product $product)
    {
        return view('products.show', compact('product'));
    }
}
