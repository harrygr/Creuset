<?php

namespace Creuset\Http\Controllers;

use Creuset\Repositories\Product\ProductRepository;
use Creuset\Term;

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
        if (!$product_category->slug) {
            $products = $this->products->getPaginated();
        } else {
            $products = $this->products->inCategory($product_category);
        }

        return view('shop.index')->with(compact('product_category', 'products'));
    }
}
