@extends('admin.layouts.admin')

@section('title')
Create Product
@stop

@section('heading')
Create Product
@stop

@section('admin.content')

@include('partials.errors')

<div class="row post-form" id="postForm">
	{!! Form::model($product, ['route' => 'admin.products.store', 'method' => 'POST']) !!}
	
	@include('admin.products.form')
	{!! Form::close() !!}
</div>
@stop