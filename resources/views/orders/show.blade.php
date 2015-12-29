@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/account">My Account</a></li>
  <li class="active">View Order</li>
</ol>

<h1>Order #{{$order->id }}</h1>
<?php var_dump($order->toArray()); ?>
@stop