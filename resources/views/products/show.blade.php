@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
  <li><a href="/shop/{{ $product->product_category->slug }}">{{ $product->product_category->term }}</a></li>
  <li class="active">{{ $product->name }}</li>
</ol>

@include('partials.errors')

<div class="row">
    <div class="col-md-4">
        {{ $product->present()->thumbnail() }}
    </div>
    <div class="col-md-8">
        <h2>{{ $product->name }}</h2>

        <p class="price">
            {{ $product->present()->price() }}
        </p>
        <p class="stock">
            {{ $product->present()->stock() }}
        </p>

        @if ($product->inStock())
        <form action="/cart" method="POST" class="form-inline">
            {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="form-group">
                <label for="quantity" class="sr-only">Quantity</label>
                <input type="number" name="quantity" value="1" min="1" step="1" max="{{ $product->stock_qty }}" class="form-control">
            </div>
            <input type="submit" class="btn btn-success" value="Add To Cart">
        </form>
        @endif

        <div class="description">
            {!! $product->getDescriptionHtml() !!}
        </div>
    </div>
</div>

@stop