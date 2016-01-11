@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
  <li class="active">Cart</li>
</ol>

<table class="table">
<tr>
  <th></th>
  <th></th>
  <th>Product</th>
  <th>Unit Price</th>
  <th>Quantity</th>
  <th>Total Price</th>
</tr>
@foreach (Cart::content() as $item)
<tr>
    <td>
        <form action="{{ route('cart.remove', $item->rowid) }}" method="POST" style="display:inline-block;">
            {{ csrf_field() }}
            {{ method_field('delete') }}
            <input type="submit" value="X" class="btn btn-link text-danger">
        </form>
        </td>
    <td>{{ $item->product->present()->thumbnail(45) }}</td>
    <td><a href="{{ $item->product->url }}">{{ $item->name }}</a></td>
    <td>{{ $item->product->present()->price() }}</td>
    <td>{{ $item->qty }}</td>
    <td>{{ Present::money($item->product->getPrice() * $item->qty) }}</td>
    </tr>
@endforeach
<tr>
  <th colspan="5"></th>
  <th>{{ Present::money(Cart::total()) }}</th>
</tr>
</table>

<a href="/checkout" class="btn btn-success">Proceed to Checkout</a>

@stop