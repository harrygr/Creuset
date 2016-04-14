@extends('admin.layouts.admin')

@section('title')
Shipping Methods
@stop

@section('heading')
{{ $title or 'Shipping Methods' }}
@stop


@section('admin.content')



<div class="box box-primary">
	<div class="box-body">


		<table class="table">
			<thead>
				<th>Description</th>
				<th>Base Rate</th>
				<th>Countries Allowed</th>
				<th></th>
			</thead>
			<tbody>
				@foreach($shipping_methods as $method)
				<tr>
					<td>{{ $method->description }}</td>
					<td>{{ Present::money($method->getPrice()) }}</td>
					<td>{{ $method->shipping_countries->implode('country_id', ', ') }}</td>
					<td>
						<a href="{{ route('admin.shipping_methods.edit', $method) }}" class="btn btn-link">Edit</a>
						@include('partials._delete_link', ['url' => route('admin.shipping_methods.delete', $method)])
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>

	</div>
</div>

<div class="box box-primary">
	<div class="box-header">
		New Shipping Rate
	</div>
	<div class="box-body">

		@include('admin.shipping_methods._form', ['shipping_method' => new App\ShippingMethod, 'route' => null])


	</div>
</div>


@stop
