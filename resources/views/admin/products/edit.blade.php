@extends('admin.layouts.admin')

@section('title')
Edit Product
@stop

@section('admin.content')

@include('partials.nav')

<h1>Edit Product</h1>
<p>
    <a href="{{ $product->url }}" class="btn btn-default">View Product</a>
</p>

@include('partials.errors')

<div class="post-form row" id="postForm">

  {!! Form::model($product, ['route' => ['admin.products.update', $product->id], 'method' => 'PATCH']) !!}

  @include('admin.products.form', ['submitText' => 'Update'])

  {!! Form::close() !!}

</div>

@stop

