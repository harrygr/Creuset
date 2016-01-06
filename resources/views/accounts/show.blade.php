@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li class="active">My Account</li>
</ol>

<h1>My Account</h1>

<p>Hello {{ $user->name }} (not {{ $user->name }}? <a href="{{ route('auth.logout') }}">Sign out</a>). From your account dashboard you can view your recent orders and manage your addresses.</p>

<h2>Recent Orders</h2>
<table class="table">
    <thead>
        <tr>
            <th>Order</th>
            <th>Date</th>
            <th>Status</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user->orders as $order)
            <tr>
                <td><a href="{{ route('orders.show', $order) }}">{{ $order->id }}</a></td>
                <td>{{ $order->created_at }}</td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->total_paid }} for {{ $order->items->count() }} {{ str_plural('item', $order->items->count()) }}</td>
            </tr>
        @endforeach
    </tbody>

</table>


<a href="{{ route('addresses.index') }}">Manage Addresses</a>


@stop