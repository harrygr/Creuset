@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
  <li class="active">Cart</li>
</ol>

<h1>Shopping Cart</h1>
<div class="row">

    <div class="col-sm-8 col-md-9">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Product</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach (Cart::content() as $item)
                <tr>
                    <td>
                        <form action="{{ route('cart.remove', $item->rowid) }}" method="POST" style="display:inline-block;">
                            {{ csrf_field() }}
                            {{ method_field('delete') }}
                            <button type="submit" class="btn btn-link text-danger" name="remove"><i class="fa fa-times text-danger"></i></button>
                        </form>
                    </td>
                    <td>{{ $item->product->present()->thumbnail(45) }}</td>
                    <td><a href="{{ $item->product->url }}">{{ $item->name }}</a></td>
                    <td>{{ $item->product->present()->price() }}</td>
                    <td>{{ $item->qty }}</td>
                    <td>{{ Present::money($item->product->getPrice() * $item->qty) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5"></th>
                    <th>{{ Present::money(Cart::total()) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div class="col-sm-4 col-md-3">
        <div class="panel panel-default">
            <div class="panel-body">
                <p class="text-center">Subtototal ({{ Cart::count() }} {{ str_plural('Item', Cart::count()) }}):{{ Present::money(Cart::total()) }}</p>
                <a href="/checkout" class="btn btn-success btn-block">Proceed to Checkout</a>
            </div>
        </div>
    </div>

</div>

@stop
