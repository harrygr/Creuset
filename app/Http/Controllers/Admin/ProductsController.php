<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreateProductRequest;
use Creuset\Http\Requests\UpdateProductRequest;
use Creuset\Product;
use Creuset\Repositories\Product\ProductRepository;

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
    }

    public function create(Product $product)
    {
        return view('admin.products.create')->with(compact('product'));
    }

    public function store(CreateProductRequest $request)
    {
        $product = $this->products->create($request->all());

        return redirect()->route('admin.products.edit', $product)
                         ->withAlert('Product Saved')
                         ->with('alert-class', 'success');
    }

    public function edit(Product $product)
    {
        $selected_product_categories = $product->terms()->where('taxonomy', 'product_category')->lists('id');

        return view('admin.products.edit')->with(compact('product', 'selected_product_categories'));
    }

    public function update(Product $product, UpdateProductRequest $request)
    {
        $product->update($request->all());
        if ($request->has('terms')) {
            $product->terms()->sync($request->terms);
        }

        return redirect()->route('admin.products.edit', $product)
                         ->withAlert('Product Updated')
                         ->with('alert-class', 'success');
    }

    public function images(Product $product)
    {
        return view('admin.products.images')->with(compact('product'));
    }
}
