@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/account">My Account</a></li>
  <li class="active">View Order</li>
</ol>

<h1>Order #{{$order->id }}</h1>

<p>Order {{$order->id }} was placed on {{ $order->created_at->toDayDateTimeString() }} and is {{ $order->status }}.</p>
<h2>Order Details</h2>

<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
        <tr>
            <td>
                <a href="{{ $item->orderable->url }}">{{ $item->orderable->name }}</a> x{{ $item->quantity}}
            </td>
            <td>{{ $item->total_paid }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right">Total</th>
            <th>{{ $order->total_paid }}</th>
        </tr>
    </tfoot>
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

@stop