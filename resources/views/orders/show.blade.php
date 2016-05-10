@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/account">My Account</a></li>
  <li class="active">View Order</li>
</ol>

<h1>Order #{{$order->id }}</h1>

<p>Order #{{$order->id }} was placed on {{ $order->created_at->toDayDateTimeString() }} and is <strong>{{ $order->present()->status(true) }}</strong>.</p>

@if($order->status === App\Order::PENDING)
    This order is not yet paid for. <a href="{{ route('checkout.pay') }}" class="btn btn-default">Pay Now</a>
@endif

<h2>Order Details</h2>

@include('orders._summary')

@stop