@extends('admin.layouts.admin')

@section('title')
Edit Post
@stop

@section('admin.content')
<h1>Edit Product</h1>

@include('partials.errors')

<div class="post-form row" id="postForm">

  {!! Form::model($product, ['route' => ['admin.products.update', $product->id], 'method' => 'PATCH']) !!}

  @include('admin.products.form', ['submitText' => 'Update'])

  {!! Form::close() !!}

</div>

@stop

