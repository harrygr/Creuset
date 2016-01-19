@extends('admin.layouts.admin')

@section('title')
Orders
@stop

@section('admin.content')

<a href="{{route('admin.posts.create')}}" class="btn btn-success pull-right">New Order</a>

	<h1>{{ $title or 'Orders' }}</h1>

	<div class="panel panel-default">
		<div class="panel-body">
	@if ($orders->count())

		<table class="table table-striped">
			<thead>
				<tr>
                    <th>Status</th>
					<th>Order</th>
					<th>Purchased</th>
					<th>Ship To</th>
					<th>Date</th>
                    <th>Total</th>
                    <th></th>
				</tr>
			</thead>
			<tbody>
			@foreach ($orders as $order)
				<tr>
                    <td>{{ $order->present()->status }}</td>
					<td>
						<a href="{{ route('admin.orders.show', $order) }}">#{{ $order->id }}</a> from {{ $order->user->username }}<br>
                        {{ $order->user->email }}
					</td>
					<td>{{ $order->product_items->count() }} items</td>
					<td>
						@include('partials.address', ['address' => $order->shipping_address])
						<span class="text-muted">Via {{ $order->shipping_item->description }}</span>
					</td>
					<td>{{ $order->created_at }}</td>
                    <td>{{ Present::money($order->amount) }}</td>
                    <td>
                    @if ($order->status == Creuset\Order::PAID)
                    	@include('admin.orders.partials._complete_button', ['order' => $order])
                    @endif
                    </td>
				</tr>
			@endforeach
			</tbody>
		</table>

		<!-- Pagination -->
		{!! $orders->render() !!}
	@else
	<p>
		No orders yet...
	</p>
	@endif
</div>
</div>


@stop
