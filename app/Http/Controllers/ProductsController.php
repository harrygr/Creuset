<?php

namespace Creuset\Http\Controllers;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Product;
use Creuset\Term;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    /**
     * Display a single product page
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
