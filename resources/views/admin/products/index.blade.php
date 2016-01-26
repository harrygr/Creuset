@extends('admin.layouts.admin')

@section('title')
Products
@stop

@section('heading')
{{ $title or 'Products' }}
@stop


@section('admin.content')

<p>
	<a href="{{route('admin.products.create')}}" class="btn btn-success pull-right">New Product</a>
</p>

<p><a href="{{ route('admin.products.index') }}">All</a> ({{ $productCount }}) | <a href="{{ route('admin.posts.trash') }}">Trash</a> ({{-- $trashedCount --}})</p>

	<div class="box box-primary">
		<div class="box-body">

		<table class="table table-striped">
			<thead>
				<tr>
					<th></th>
					<th>Product</th>
					<th>SKU</th>
					<th>Stock</th>
					<th>Price</th>
					<th>Categories</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($products as $product)
				<tr>
					<td>
						<a href="{{ route("admin.products.edit", $product) }}">
						{{ $product->present()->thumbnail(40) }}
						</a>
					</td>
					<td>
						<strong>{{ $product->name }}</strong>
						<div class="row-actions">
							{{ $product->present()->indexLinks() }}
						</div>
					</td>
					<td>{{ $product->sku }}</td>
					<td>{{ $product->stock_qty }}</td>
					<td>{{ $product->present()->price() }}</td>
					<td>{{ $product->present()->categoryList() }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<!-- Pagination -->
		{!! $products->render() !!}
		</div>
	</div>


@stop
