@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  @if ($product_category->id or 'uncategorised' == $product_category->slug)
  <li><a href="/shop">Shop</a></li>
  <li class="active">{{ $product_category->term }}</li>
  @else
  <li class="active">Shop</li>
  @endif
</ol>

@foreach ($products->chunk(4) as $product_group)
<div class="row">

    @foreach ($product_group as $product)
    <div class="product col-md-3 col-xs-6">
        <a href="{{ $product->url }}">
        <img src="{{ $product->present()->thumbnail_url(300) }}" alt="" class="img-responsive">
        
        </a>
        <a href="{{ $product->url }}">
        <h3>{{ $product->name }}</h3>
        </a>
        <span class="price">{{ $product->present()->price() }}</span>
    </div>
    @endforeach
    
</div>
@endforeach

{!! $products->render() !!}

@stop