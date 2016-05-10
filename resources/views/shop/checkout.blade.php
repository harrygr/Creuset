@inject('countries', 'App\Countries\CountryRepository')

@extends('layouts.main')

@section('breadcrumb')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
  <li><a href="/cart">Cart</a></li>
  <li class="active">Checkout</li>
</ol>

@endsection

@section('content')


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
  <td>{{ Present::money($item->product->getPrice() * $item->qty) }}</td>
</tr>
@endforeach

<tr>
  <th colspan="2"></th>
  <th>{{ Present::money(Cart::total()) }}</th>
</tr>
</table>

@include('partials.errors')

<div id="checkout">
  <form action="orders" method="POST" id="checkout-form">
    {{ csrf_field() }}


    @if (Auth::guest())
    <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
      <label class="control-label" for="email">Email</label>
      <input type="email" name="email" value="{{ old('email', $order->email) }}" class="form-control">
    </div>

    <div class="checkbox">
      <label>
        <input type="checkbox" name="create_account" {{ old('create_account') ? 'checked' : '' }} v-model="create_new_account"> Create an account?
      </label>
    </div>

    <div v-show="create_new_account">
      <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
        <label class="control-label" for="password">Password</label>
        <input type="password" name="password" class="form-control">
      </div>

      <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
        <label class="control-label" for="password_confirmation">Password Confirmation</label>
        <input type="password" name="password_confirmation" class="form-control">
      </div>
    </div>

    <p>Already registered? <a href="login">Login</a></p>
    @endif

    {{-- Saved Addresses --}}
    @if (Auth::check() and Auth::user()->addresses->count())
    <div class="row">
      <div class="col-md-6">
        <h3>Billing Address</h3>
        @foreach (Auth::user()->addresses as $address)
        <div class="radio">
          <label>
            {!! Form::radio('billing_address_id', $address->id, $address->id == $order->billing_address_id, ['id' =>"billing_address_{$address->id}" ]) !!}
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
            {!! Form::radio('shipping_address_id', $address->id, $address->id == $order->shipping_address_id, ['id' =>"shipping_address_{$address->id}" ]) !!}
            @include('partials.address', compact('address'))
          </label>
        </div>
        @endforeach
      </div>
    </div>

    <p>
      <a href="{{ route('addresses.create') }}" class="btn btn-default">Add new address</a>
    </p>

    @else
    <div class="row">
      <div class="col-md-6">
        <h3>Billing Address</h3>
        @include('partials.address_form', ['type' => 'billing'])
      </div>
      <div class="col-md-6">
        <h3>Shipping Address</h3>
        <div class="checkbox" style="position: absolute; top: 16px; right: 16px;">
          <label><input type="checkbox" name="different_shipping_address" {{ old('different_shipping_address') ? 'checked' : '' }} v-model="different_shipping_address"> Different Shipping Address</label>
        </div>
        <i v-show="!different_shipping_address">Same as billing</i>
        <div v-show="different_shipping_address">
          @include('partials.address_form', ['type' => 'shipping'])
        </div>
      </div>
    </div>
    @endif
    <div class="row">
    <p class="col-sm-4 col-sm-offset-8 col-md-2 col-md-offset-10">
      <input type="submit" class="btn btn-success btn-lg btn-block" value="Continue">
    </p>
    </div>
  </form>
</div>

@stop

@section('scripts')
<script>
  var vm = new Vue({
    el: '#checkout-form',

    data: {
      different_shipping_address: null,
      create_new_account: null,
    }
  })

</script>
@stop
