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

  @include('shop._product_search')

  @foreach ($products->chunk($products_per_row) as $product_group)
  <div class="row">

      @foreach ($product_group as $i => $product)
      <div class="product col-md-{{ (int) 12 / $products_per_row }} col-xs-{{ (int) 24 / $products_per_row }} top-buffer">
        @include('shop._product_tile', compact('product'))
      </div>

      @if( ($i + 1) % ($products_per_row / 2) === 0 )
        <div class="clearfix visible-xs-block"></div>
      @endif

      @endforeach

  </div>
  @endforeach

  {!! $products->render() !!}

@stop
