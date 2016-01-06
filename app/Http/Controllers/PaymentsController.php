<?php

namespace Creuset\Http\Controllers;

use Creuset\Billing\GatewayInterface;
use Creuset\Http\Controllers\Controller;
use Creuset\Http\Requests;
use Creuset\Order;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Create a new payment for an order
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function store(Request $request, GatewayInterface $gateway)
    {
        $this->validate($request, ['order_id' => 'required|numeric', 'stripe_token' => 'required']);
     
        $request->session()->forget('order');
        
        $order = Order::find($request->order_id);

        $charge = $gateway->charge([
            'amount' => $order->amount * 100,
            'card'   => $request->stripe_token,
            'description' => sprintf("Order #%s", $order->id),
            ]);

        $order->update([
            'payment_id' => $charge->id,
            'status'     => 'paid'
            ]);
        
        \Cart::destroy();

        $request->session()->flash('order', $order);
        return redirect()->route('orders.completed');
    }
}
