<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Http\Requests\CreateProductRequest;
use Creuset\Http\Requests\UpdateProductRequest;
use Creuset\Product;
use Creuset\Repositories\Product\ProductRepository;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
	private $products;

	public function __construct(ProductRepository $products)
	{
		$this->middleware('auth');
		$this->products = $products;
	}

    public function index()
    {
        $products = Product::paginate();
        $productCount = Product::count();
        return view('admin.products.index', compact('products', 'productCount'));
        var_dump(Product::all()->toArray());
    }

    public function create()
    {
    	$product = new Product;

    	return view('admin.products.create')->with(compact('product'));
    }

    public function store(CreateProductRequest $request)
    {
    	$this->products->create($request->all());
    	return redirect()->route('admin.products.index')
                         ->withAlert('Product Saved')
                         ->with('alert-class', 'success');
    }

    public function edit(Product $product)
    {
    	return view('admin.products.edit')->with(compact('product'));
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
    	$product->update($request->all());
    	return redirect()->route('admin.products.index')->withAlert('Product Updated')->with('alert-class', 'success');
    }
}
