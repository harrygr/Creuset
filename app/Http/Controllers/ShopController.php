<?php

namespace App\Http\Controllers;

use App\ProductAttributeFilter;
use App\Repositories\Product\ProductRepository;
use App\Search\ProductSearcher;
use App\Term;
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
    public function index(Term $product_category, ProductAttributeFilter $filter)
    {
        if (!$product_category->slug) {
            $products = $this->products->getPaginated(['image']);
        } else {
            $products = $product_category->products()->filter($filter)->with('image')->paginate();
        }

        return view('shop.index')->with(compact('product_category', 'products'));
    }

    /**
     * Perform a search for products and display the results.
     * Here we are just extracting the IDs of the result and querying the products from the DB.
     * We will have a more snappy JS-powered search on the front end.
     *
     * @param Request         $request
     * @param ProductSearcher $searcher
     *
     * @return Illuminate\Http\Response
     */
    public function search(Request $request, ProductSearcher $searcher)
    {
        $product_category = new Term();

        $results = $searcher->search($request->get('query'));
        $products = \App\Product::whereIn('id', $results->pluck('id'))->paginate();

        return view('shop.index')->with(compact('product_category', 'products'));
    }
}
