@extends('layouts.main')

@section('content')

@foreach ($products->chunk(4) as $product_group)
<div class="row">

    @foreach ($product_group as $product)
    <div class="product col-md-3">
        <a href="{{ route('products.show', $product->slug) }}">
        {{ $product->present()->thumbnail() }}
        </a>
        <a href="{{ route('products.show', $product->slug) }}">
        <h3>{{ $product->name }}</h3>
        </a>
        <span class="price">{{ $product->present()->price() }}</span>
    </div>
    @endforeach
</div>
@endforeach
@stop