<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductAttribute\CreateProductAttributeRequest;
use App\ProductAttribute;
use Illuminate\Http\Request;

class ProductAttributesController extends Controller
{

    public function __construct()
    {
        $this->middleware('admin', ['only' => ['store', 'update', 'destroy', 'storeCategory']]);
    }

    /**
     * Get all properties for a given attribute.
     *
     * @param string $slug The slug of the attribute
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        if ($slug) {
            return ProductAttribute::where('slug', str_slug($slug))->get();
        }
        return ProductAttribute::all();        
    }


    /**
     * Create a new property in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductAttributeRequest $request)
    {
        return ProductAttribute::create($request->all());
    }

    /**
     * Delete a property from storage.
     *
     * @param ProductAttribute $property
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductAttribute $product_attribute)
    {
        $product_attribute->delete();

        return 'success';
    }

    /**
     * Update a property in storage.
     *
     * @param \App\ProductAttribute                                 $property
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function update(ProductAttribute $product_attribute, Request $request)
    {
        $product_attribute->update($request->all());

        return $product_attribute;
    }
}
