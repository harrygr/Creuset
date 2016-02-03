@extends('emails.main')

@section('content')
    <p>Thank you for your order</p>

    <p>Your order has been received and is now being processed. Your order details are shown below for your reference:</p>

    <ul>
    <li><strong>Order ID:</strong> #{{ $order->id }}</li>
    <li><strong>Order Date:</strong> {{ $order->created_at }}</li>    
    </ul>

    @include('orders._summary')
@stop