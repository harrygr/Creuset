@extends('layouts.main')

@section('content')

<ol class="breadcrumb">
  <li><a href="/shop">Shop</a></li>
</ol>

<p>There is nothing in your cart. <a href="{{ route('products.index') }}">Return to the shop</a></p>
@stop