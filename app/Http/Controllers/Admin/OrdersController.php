<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    /**
     * Show a list of orders.
     *
     * @param string $status The order status to filter by
     *
     * @return \Illuminate\Http\Response
     */
    public function index($status = null)
    {
        $orders = Order::with(['items', 'shipping_address', 'user'])->latest();

        if ($status) {
            $orders = $orders->where('status', $status);
        }

        return view('admin.orders.index')->with([
            'orders' => $orders->paginate(),
            ]);
    }

    /**
     * Show a single order's details.
     *
     * @param Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.orders.show')->with(compact('order'));
    }

    /**
     * Update an order in storage.
     *
     * @param Order $order
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Order $order, Request $request)
    {
        $order->update($request->all());

        return redirect()->back()
                         ->withAlert('Order Updated')
                         ->with('alert-class', 'success');
    }
}
