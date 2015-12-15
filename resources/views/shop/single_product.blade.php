@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-md-4">
            {{ $product->present()->thumbnail() }}
        </div>
        <div class="col-md-8">
            <h2>{{ $product->name }}</h2>
            <span class="price">
                {{ $product->present()->price() }}
            </span>
            <span class="stock">
                {{ $product->present()->stock() }}
            </span>
            <form action="/cart" method="POST">
            {{ csrf_field() }}
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="1">
            <input type="submit" class="btn btn-success" value="Add To Cart">
            </form>
            <div class="description">
                {{ $product->description }}
            </div>
        </div>
    </div>
@stop