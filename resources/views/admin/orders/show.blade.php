@extends('admin.layouts.admin')

@section('title')
Order #{{ $order->id }} Details
@stop

@section('admin.content')

<h1>Order #{{ $order->id }} Details</h1>

<div class="panel panel-default">
	<div class="panel-heading">General Details</div>

		<table class="table">
			<tbody>
				<tr>
					<th>Order Date</th>
					<td>{{ $order->created_at }}</td>
				</tr>
				<tr>
					<th>Order Status</th>
					<td>
					{{ $order->present()->status }}
					@include('admin.orders.partials._status_switcher')
					</td>
				</tr>
				<tr>
					<th>Payment ID</th>
					<td>{{ $order->payment_id }}</td>
				</tr>
				<tr>
					<th>Customer</th>
					<td><a href="{{ route('admin.users.edit', $order->customer->username) }}">{{ $order->customer->name }}</a> ({{ $order->customer->email }})</td>
				</tr>
				<tr>
					<td>
						<h4>Billing Address</h4>
						@include('partials.address', ['address' => $order->billing_address])

						Phone: {{ $order->billing_address->phone }}
					</td>
					<td>
						<h4>Shipping Address</h4>
						@include('partials.address', ['address' => $order->shipping_address])
					</td>
				</tr>
			</tbody>
		</table>


</div>

<div class="panel panel-default">
	<div class="panel-heading">Order Items</div>
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th>Item</th>
				<th>Cost</th>
				<th>Qty</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($order->items as $item)
				<tr>
					<td style="width:36px">{{ $item->orderable->present()->thumbnail(20) }}</td>
					<td><a href="{{ route('admin.products.edit', $item->orderable) }}">{{ $item->description }}</a></td>
					<td>{{ Present::money($item->price_paid) }}</td>
					<td>{{ $item->quantity }}</td>
				<td>{{ Present::money($item->total_paid) }}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr>
				<th colspan="3"></th>
				<th>Grand Total:</th>
				<th>{{ Present::money($order->amount) }}</th>
			</tr>
		</tfoot>
	</table>
</div>



@stop
