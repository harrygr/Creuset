<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Order;
use Illuminate\Http\Request;

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
