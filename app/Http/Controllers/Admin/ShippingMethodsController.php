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
        $shipping_methods = ShippingMethod::all();
        return view('admin.shipping_methods.index', compact('shipping_methods'));
    }

    public function store(Request $request)
    {
        $this->validate($request, ShippingMethod::$rules);

        ShippingMethod::create($request->all());

        return redirect()->route('admin.shipping_methods.index')->with([
            'alert'         => 'Shipping Method Saved',
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
