<?php

namespace Creuset\Http\Controllers\Api;

use Creuset\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Creuset\Order;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function update(Order $order, Request $request)
    {
        $order->update($request->all());
        return $order;
    }

}
