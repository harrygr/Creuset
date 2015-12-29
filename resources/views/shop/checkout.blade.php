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
{{-- Saved Addresses --}}
@if (Auth::check())
<div class="row">
    <div class="col-md-6">
    <h3>Billing Address</h3>
        @foreach (Auth::user()->addresses as $address)
        <div class="radio">
          <label>
            <input type="radio" name="billing_address_id" id="billing_address_{{ $address->id }}" value="{{ $address->id }}">
            @include('partials.address', compact('address'))
        </label>
        </div>
        @endforeach
    </div>
        <div class="col-md-6">
        <h3>Shipping Address</h3>
        @foreach (Auth::user()->addresses as $address)
        <div class="radio">
          <label>
            <input type="radio" name="shipping_address_id" id="shipping_address_{{ $address->id }}" value="{{ $address->id }}">
            @include('partials.address', compact('address'))
        </label>
        </div>
        @endforeach
    </div>
</div>

@else
    <div class="row">
        <div class="col-md-6">
            <h3>Billing Address</h3>
            @include('partials.address_form', ['type' => 'billing'])
        </div>
        <div class="col-md-6">
            <h3>Shipping Address</h3>
            <div class="checkbox" style="position: absolute; top: 16px; right: 16px;">
    <label><input type="checkbox" name="shipping_same_as_billing" checked> Same as Billing</label>
            </div>
            @include('partials.address_form', ['type' => 'shipping'])
        </div>
    </div>
@endif


<input type="submit" class="btn btn-success" value="Place Order">
</form>

@stop