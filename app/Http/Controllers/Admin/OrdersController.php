<?php

namespace Creuset\Http\Controllers\Admin;

use Illuminate\Http\Request;

use Creuset\Http\Requests;
use Creuset\Http\Controllers\Controller;
use Creuset\Order;

class OrdersController extends Controller
{
    public function index()
    {
        $orders = Order::with(['items', 'shipping_address', 'user'])->latest()->paginate();
        return view('admin.orders.index')->with(compact('orders'));
    }
}
