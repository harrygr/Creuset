<?php

namespace Creuset\Http\Controllers\Admin;

use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\ShippingMethod;
use Illuminate\Http\Request;

class ShippingMethodsController extends Controller
{
    public function index()
    {
        $shipping_methods = ShippingMethod::with('shipping_countries')->get();
        return view('admin.shipping_methods.index', compact('shipping_methods'));
    }

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

    public function edit(ShippingMethod $shipping_method)
    {
        return view('admin.shipping_methods.edit', compact('shipping_method'));
    }

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

    public function destroy(ShippingMethod $shipping_method)
    {
        $shipping_method->delete();

        return redirect()->route('admin.shipping_methods.index')->with([
            'alert'         => 'Shipping Method Deleted',
            'alert-class'   => 'success',
            ]);
    }
}
