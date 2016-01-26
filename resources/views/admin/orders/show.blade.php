@extends('admin.layouts.admin')

@section('title')
Order #{{ $order->id }} Details
@stop

@section('heading')
Order #{{ $order->id }} Details
@stop

@section('admin.content')

<div class="box box-primary">
	<div class="box-header">General Details</div>

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
					<td><a href="{{ route('admin.users.edit', $order->customer->username) }}">{{ $order->customer->name }}</a> ({{ $order->email }})</td>
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

<div class="box box-primary">
	<div class="box-header">Order Items</div>
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th>Item</th>
				<th>SKU</th>
				<th>Cost</th>
				<th>Qty</th>
				<th>Total</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($order->product_items as $item)
				<tr>
					<td style="width:36px">{{ $item->orderable->present()->thumbnail(20) }}</td>
					<td><a href="{{ route('admin.products.edit', $item->orderable) }}">{{ $item->description }}</a></td>
					<td>{{ $item->orderable->sku }}</td>
					<td>{{ Present::money($item->price_paid) }}</td>
					<td>{{ $item->quantity }}</td>
					<td>{{ Present::money($item->total_paid) }}</td>
				</tr>
			@endforeach

			<tr>
				<td colspan="5"></td>
			</tr>
			
			<tr>
				<td><i class="fa fa-truck"></i></td>
				<td>{{ $order->shipping_item->description}}</td>

				<td colspan="3"></td>
				<td>{{ Present::money($order->shipping_item->price_paid) }}</td>
			</tr>

		</tbody>
		<tfoot>
			<tr>
				<th colspan="4"></th>
				<th>Grand Total:</th>
				<th>{{ Present::money($order->amount) }}</th>
			</tr>
		</tfoot>
	</table>
</div>



@stop
