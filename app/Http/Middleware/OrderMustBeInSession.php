<?php

namespace Creuset\Http\Middleware;

use Closure;

class OrderMustBeInSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->session()->has('order') or !$request->session()->get('order')->exists) {
            return redirect()->route('products.index')->with([
                'alert'         => 'This page is not accessible without an order.',
                'alert-class'   => 'warning'
                ]);
        }

        return $next($request);
    }
}
