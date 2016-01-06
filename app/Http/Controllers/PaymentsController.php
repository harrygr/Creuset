<?php

namespace Creuset\Http\Controllers;

use Creuset\Billing\GatewayInterface;

use Creuset\Order;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Create a new payment for an order.
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function store(Request $request, GatewayInterface $gateway)
    {
        $this->validate($request, ['order_id' => 'required|numeric', 'stripe_token' => 'required']);
        $order = Order::find($request->order_id);

        try {
            $charge = $gateway->charge([
                'amount'      => $order->amount * 100,
                'card'        => $request->stripe_token,
                'description' => sprintf('Order #%s', $order->id),
                ]);
        } catch (\Creuset\Billing\CardException $e) {
            return redirect()->back()->with([
                'alert'       => $e->getMessage(),
                'alert-class' => 'danger',
                ]);
        }

        $request->session()->forget('order');

        event(new \Creuset\Events\OrderWasPaid($order, $charge->id));

        \Cart::destroy();

        $request->session()->flash('order_id', $order->id);

        return redirect()->route('orders.completed');
    }
}
