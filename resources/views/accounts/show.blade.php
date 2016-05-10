@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li class="active">My Account</li>
</ol>

<h1>My Account</h1>

<p>Hello {{ $user->name }} (not {{ $user->name }}? <a href="{{ route('auth.logout') }}">Sign out</a>). From your account dashboard you can view your recent orders, <a href="{{ route('addresses.index') }}">manage your addresses</a> and <a href="{{ route('accounts.edit') }}">edit your account details</a>.</p>

<h2>Recent Orders</h2>
@if ($user->hasOrders())
    <table class="table">
        <thead>
            <tr>
                <th>Order</th>
                <th>Date</th>
                <th>Status</th>
                <th>Total</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($user->orders->take(5) as $order)
                <tr>
                    <td><a href="{{ route('orders.show', $order) }}">#{{ $order->id }}</a></td>
                    <td>{{ $order->created_at->format('j M Y g:ia') }}</td>
                    <td>{{ $order->present()->status }}</td>
                    <td>{{ Present::money($order->amount) }} for {{ $order->product_items->count() }} {{ str_plural('item', $order->product_items->count()) }}</td>
                    <td>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-default">View</a>
                    @if($order->status === App\Order::PENDING)
                        <a href="{{ route('checkout.pay') }}" class="btn btn-default">Pay</a>
                    @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if ($user->orders->count() > 5)
        <p>
            <a href="/account/orders">View all orders</a>
        </p>
    @endif

@else
    <p>You haven't made any orders yet. Why not visit <a href="/shop">the shop</a></p>
@endif

<h2>Addresses</h2>
@if ($user->hasOrders())
<p>Last used addresses</p>
<div class="row">
    <div class="col-xs-6">
        <h3>Billing Address</h3>
        @include('partials.address', ['address' => $user->orders->first()->billing_address])
    </div>
    <div class="col-xs-6">
        <h3>Shipping Address</h3>
        @include('partials.address', ['address' => $user->orders->first()->shipping_address])
    </div>

</div>
@endif
<p>
    <a href="{{ route('addresses.index') }}">Manage Addresses</a>
</p>


@stop