<?php

namespace App\Http\Middleware;

use Cart;
use Closure;

class RedirectIfCartIsEmpty
{
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
        if (!Cart::count()) {
            return redirect()->route('products.index')->with([
                'alert'         => 'There is nothing in your cart.',
                'alert-class'   => 'warning',
                ]);
        }

        return $next($request);
    }
}
