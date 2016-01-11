@extends('admin.layouts.admin')

@section('title')
Orders
@stop

@section('admin.content')

<a href="{{route('admin.posts.create')}}" class="btn btn-success pull-right">New Order</a>

	<h1>{{ $title or 'Orders' }}</h1>

	<div class="panel panel-default">
		<div class="panel-body">

		<table class="table table-striped">
			<thead>
				<tr>
                    <th>Status</th>
					<th>Order</th>
					<th>Purchased</th>
					<th>Ship To</th>
					<th>Date</th>
                    <th>Total</th>
				</tr>
			</thead>
			<tbody>
			@foreach ($orders as $order)
				<tr>
                    <td>{{ $order->status }}</td>
					<td>
						<strong>#{{ $order->id }}</strong> from {{ $order->user->username }}<br>
                        {{ $order->user->email }}
					</td>
					<td>{{ $order->items()->count() }} items</td>
					<td>@include('partials.address', ['address' => $order->shipping_address])</td>
					<td>{{ $order->created_at }}</td>
                    <td>{{ Present::money($order->amount) }}</td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<!-- Pagination -->
		{!! $orders->render() !!}
		</div>
	</div>


@stop
