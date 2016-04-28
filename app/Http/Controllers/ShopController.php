<?php

namespace App\Http\Controllers;

use App\ProductAttributeFilter;
use App\Repositories\Product\ProductRepository;
use App\Term;

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
    public function index(Term $product_category = null, ProductAttributeFilter $filter)
    {
        if (!$product_category->slug) {
            $products = $this->products->getPaginated(['image']);
        } else {
            $products = $product_category->products()->filter($filter)->with('image')->paginate();
        }

        return view('shop.index')->with(compact('product_category', 'products'));
    }
}
