@extends('layouts.main')

@section('content')

@if ($order)
<h1>Order Completed</h1>

<p>Your order details are below</p>

<ul>
<li>Order ID: {{ $order->id }}</li>
    <li>Date: {{ $order->created_at }}</li>
    <li>Total: {{ $order->amount }}</li>
</ul>

<h2>Order Summary</h2>
<table class="table">
<tr>
    <th>Product</th>
    <th>Total</th>
</tr>
@foreach ($order->items as $item)
<tr>
    <td>{{ $item->description }} x{{ $item->quantity }}</td>
    <td>{{ $item->price_paid * $item->quantity }}</td>
</tr>
@endforeach

<tr>
    <th class="text-right">Order Total</th>
    <th>{{ $order->amount }}</th>
</tr>
</table>


<div class="row">
    <div class="col-md-6">
        <h3>Billing Address</h3>
        @include('partials.address', ['address' => $order->billing_address])
    </div>
    <div class="col-md-6">
        <h3>Shipping Address</h3>
        @include('partials.address', ['address' => $order->shipping_address])
    </div>
</div>
@else
No Order Here
@endif
@stop