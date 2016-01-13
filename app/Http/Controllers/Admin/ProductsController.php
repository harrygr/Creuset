<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests\CreateProductRequest;
use Creuset\Http\Requests\UpdateProductRequest;
use Creuset\Product;
use Creuset\Repositories\Product\ProductRepository;

class ProductsController extends Controller
{
    /**
     * @var \Creuset\Repositories\Product\ProductRepository
     */
    private $products;

    /**
     * Create a new ProductsController instance
     * @param ProductRepository $products
     */
    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }

    /**
     * Show a list of all the products
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate();
        $productCount = Product::count();

        return view('admin.products.index', [
            'products' => $this->products->getPaginated(['image', 'product_categories']),
            'productCount' => $this->products->count(),
        ]);
    }

    /**
     * Show the page for creating a new product
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function create(Product $product)
    {
        return view('admin.products.create')->with(compact('product'));
    }

    /**
     * Create a product in storage
     * @param  CreateProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {      
        $product = Product::create($request->all());

        $product->syncTerms($request->get('terms', []));

        return redirect()->route('admin.products.edit', $product)
                         ->withAlert('Product Saved')
                         ->with('alert-class', 'success');
    }

    /**
     * Show the page for editing a product
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $selected_product_categories = $product->product_categories->lists('id');

        return view('admin.products.edit')->with(compact('product', 'selected_product_categories'));
    }

    /**
     * Update a product in storage
     * @param  Product              $product 
     * @param  UpdateProductRequest $request 
     * @return \Illuminate\Http\Response
     */
    public function update(Product $product, UpdateProductRequest $request)
    {
        $product->update($request->all());

        $product->syncTerms($request->get('terms', []));

        return redirect()->route('admin.products.edit', $product)
                         ->withAlert('Product Updated')
                         ->with('alert-class', 'success');
    }

    /**
     * Show the page for attaching images to a product
     * @param  Product $product 
     * @return \Illuminate\Http\Response
     */
    public function images(Product $product)
    {
        return view('admin.products.images')->with(compact('product'));
    }

    /**
     * Delete a Product
     * @param  Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
                         ->withAlert('Product Deleted')
                         ->with('alert-class', 'success');
    }
}
