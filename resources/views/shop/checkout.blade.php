@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
  <li><a href="/cart">Cart</a></li>
  <li class="active">Checkout</li>
</ol>

<h2>Order Summary</h2>

<table class="table">
    <th></th>
    <th>Product</th>
    <th>Total Price</th>
</tr>
@foreach (Cart::content() as $item)
<tr>
    <td>{{ $item->product->present()->thumbnail(45) }}</td>
    <td>{{ $item->name }} x{{ $item->qty }}</td>
    <td>&pound;{{ $item->product->getPrice() * $item->qty }}</td>
</tr>
@endforeach
<tr>
  <th colspan="2"></th>
  <th>&pound;{{ Cart::total() }}</th>
</tr>
</table>

@include('partials.errors')

<form action="orders" method="POST">
    {{ csrf_field() }}
    @if (Auth::guest())
    <div class="form-group">
      <label for="name">Your name</label>
      <input type="text" name="name" value="{{ old('name') }}" class="form-control">
  </div>

  <div class="form-group">
      <label for="email">Email</label>
      <input type="email" name="email" value="{{ old('email') }}" class="form-control">
  </div>

  <div class="checkbox">
    <label>
    <input type="checkbox" name="create_account"> Create an account?
    </label>
</div>

<div class="form-group">
  <label for="password">Password</label>
  <input type="password" name="password" class="form-control">
</div>
<div class="form-group">
  <label for="password_confirmation">Password Confirmation</label>
  <input type="password" name="password_confirmation" class="form-control">
</div>
<p>Already registered? <a href="login">Login</a></p>
@endif


<input type="submit" class="btn btn-success" value="Place Order">
</form>

@stop