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

@include('shop._attribute_filter')

@foreach ($products->chunk($products_per_row) as $product_group)
<div class="row">

    @foreach ($product_group as $i => $product)
    <div class="product col-md-{{ 12 / $products_per_row }} col-xs-{{ 24 / $products_per_row }}">
        <a href="{{ $product->url }}">
          <img src="{{ $product->present()->thumbnail_url(300) }}" alt="" class="img-responsive">        
        </a>
        <a href="{{ $product->url }}">
        <h3>{{ $product->name }}</h3>
        </a>
        <span class="price">{{ $product->present()->price() }}</span>
    </div>

    @if(($i+1) % ($products_per_row / 2) === 0)
      <div class="clearfix visible-xs-block"></div>
    @endif

    @endforeach
    
</div>
@endforeach

{!! $products->render() !!}

@stop