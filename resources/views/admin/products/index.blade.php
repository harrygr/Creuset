@extends('admin.layouts.admin')

@section('title')
Products
@stop

@section('admin.content')

<a href="{{route('admin.products.create')}}" class="btn btn-success pull-right">New Product</a>

	<h1>{{ $title or 'Products' }}</h1>

	<a href="{{ route('admin.products.index') }}">All</a> ({{ $productCount }}) | <a href="{{ route('admin.posts.trash') }}">Trash</a> ({{-- $trashedCount --}})

	<div class="panel panel-default">
		<div class="panel-body">

		<table class="table table-striped">
			<thead>
				<tr>
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