<?php

namespace Creuset\Http\Controllers;

use Creuset\Product;
use Creuset\Repositories\Product\ProductRepository;
use Creuset\Term;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $products;

    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Term $product_category = null)
    {
        //dd($product_category);
        if (!$product_category->slug) {
            $products = $this->products->all();
        } else {
            $products = $this->products->inCategory($product_category);
        }

        return view('shop.index')->with(compact('product_category', 'products'));
    }
}
