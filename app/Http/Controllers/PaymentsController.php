<?php

namespace App\Http\Controllers;

use App\Billing\GatewayInterface;
use App\Order;
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
                ], [
                    'email' => $order->email,
                ]);
        } catch (\App\Billing\CardException $e) {
            return redirect()->back()->with([
                'alert'       => $this->paymentErrorMessage($e->getMessage()),
                'alert-class' => 'danger',
                ]);
        }

        $request->session()->forget('order');
        event(new \App\Events\OrderWasPaid($order, $charge->id));

        \Cart::destroy();

        $request->session()->flash('order_id', $order->id);

        return redirect()->route('orders.completed');
    }

    /**
     * Derive the payment error message.
     *
     * @param string $message
     *
     * @return string|HtmlString
     */
    private function paymentErrorMessage($message)
    {
        if (strpos($message, 'zip code')) {
            return new \Illuminate\Support\HtmlString('The postcode you supplied failed validation, please check your billing address on the <a href="/checkout" class="alert-link" title="return to the checkout page">checkout page</a>.');
        }

        return $message;
    }
}
