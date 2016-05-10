<?php

namespace App\Http\Middleware;

use Closure;

class OrderMustBeInSession
{
    private $order;

    /**
     * Set the order.
     *
     * @param \Illuminate\Http\Request $request
     */
    private function setOrder($request)
    {
        $this->order = $request->session()->get('order', null);
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->setOrder($request);

        if (!$this->orderExists() or !$this->orderNeedsPayment()) {
            return redirect()->route('products.index')->with([
                'alert'         => 'No order exists or your order has expired. Please try again.',
                'alert-class'   => 'warning',
                ]);
        }

        return $next($request);
    }

    /**
     * Is an order that exists in the database in the session?
     *
     * @return bool
     */
    private function orderExists()
    {
        return !is_null($this->order) and $this->order->exists;
    }

    /**
     * Does the order in the session need payment?
     * I.E. Is it pending?
     *
     * @return bool
     */
    private function orderNeedsPayment()
    {
        return $this->order->fresh()->status === \App\Order::PENDING;
    }
}
