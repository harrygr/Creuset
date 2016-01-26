@extends('admin.layouts.admin')

@section('title')
Edit Shipping Method
@stop

@section('heading')
{{ $title or 'Edit Shipping Method' }}
@stop


@section('admin.content')


<div class="box box-primary">
	<div class="box-header">
		Edit Shipping Rate
	</div>
	<div class="box-body">

		@include('admin.shipping_methods._form', ['route' => ['admin.shipping_methods.update', $shipping_method], 'method' => 'patch'])

	</div>
</div>


@stop
