@inject('countries', 'App\Countries\CountryRepository')

@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
  <li><a href="/cart">Cart</a></li>
  <li class="active">Checkout</li>
</ol>

<h2>Shipping Method</h2>

@include('partials.errors')

<form action="/orders/shipping" method="POST" id="shipping-form">
  {{ csrf_field() }}
  <div class="form-group">

    @foreach ($shipping_methods as $shipping_method)
    <div class="radio">
      <label>
        {!! Form::radio('shipping_method_id', $shipping_method->id, $shipping_method->id == old('shipping_method_id'), ['id' =>"shipping_method_{$shipping_method->id}" ]) !!}
        {{ $shipping_method->description }}: {{ Present::money($shipping_method->getPrice()) }}
      </label>
    </div>
    @endforeach

  </div>

  <button type="submit" class="btn btn-success">Proceed to Payment</button>

</form>


@stop
