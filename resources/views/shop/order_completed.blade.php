@extends('layouts.main')

@section('content')
<h1>Order Completed</h1>

<p>Your order details are below</p>

<ul>
<li>Order ID: {{ $order->id }}</li>
    <li>Date: {{ $order->created_at }}</li>
    <li>Total: {{ Present::money($order->amount) }}</li>
</ul>

<h2>Order Summary</h2>
@include('orders._summary')

@stop