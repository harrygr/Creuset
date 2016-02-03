@extends('emails.main')

@section('content')
    <p>You have a new customer order</p>

    <p>Order details:</p>

    <ul>
    <li><strong>Order ID:</strong> #{{ $order->id }}</li>
    <li><strong>Order Date:</strong> {{ $order->created_at }}</li>    
    </ul>

    @include('orders._summary')
@stop