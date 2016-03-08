<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\ShippingMethod\ShippingMethodRepository;
use App\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodsController extends Controller
{
    private $shipping_methods;

    public function __construct(ShippingMethodRepository $shipping_methods)
    {
        $this->shipping_methods = $shipping_methods;
    }

    /**
     * Show the index page for managing shipping methods.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        $shipping_methods = $this->shipping_methods->all(['shipping_countries']);

        return view('admin.shipping_methods.index', compact('shipping_methods'));
    }

    /**
     * Create a new shipping method in storage.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ShippingMethod::$rules);

        $shipping_method = ShippingMethod::create($request->all());
        $shipping_method->allowCountries($request->get('shipping_countries', []));

        return redirect()->route('admin.shipping_methods.index')->with([
            'alert'         => 'Shipping Method Saved',
            'alert-class'   => 'success',
            ]);
    }

    /**
     * Show the page for editing a shipping method.
     *
     * @param ShippingMethod $shipping_method
     *
     * @return Illuminate\Http\Response
     */
    public function edit(ShippingMethod $shipping_method)
    {
        return view('admin.shipping_methods.edit', compact('shipping_method'));
    }

    /**
     * Update a shipping method in storage.
     *
     * @param Request        $request
     * @param ShippingMethod $shipping_method
     *
     * @return Illuminate\Http\Response
     */
    public function update(Request $request, ShippingMethod $shipping_method)
    {
        $this->validate($request, ShippingMethod::$rules);

        $shipping_method->update($request->all());
        $shipping_method->allowCountries($request->get('shipping_countries', []));

        return redirect()->route('admin.shipping_methods.index')->with([
            'alert'         => 'Shipping Method Updated',
            'alert-class'   => 'success',
            ]);
    }

    /**
     * Remove a shipping method from storage.
     *
     * @param ShippingMethod $shipping_method
     *
     * @return Illuminate\Http\Response
     */
    public function destroy(ShippingMethod $shipping_method)
    {
        $shipping_method->delete();

        return redirect()->route('admin.shipping_methods.index')->with([
            'alert'         => 'Shipping Method Deleted',
            'alert-class'   => 'success',
            ]);
    }
}
