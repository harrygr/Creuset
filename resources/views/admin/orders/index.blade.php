@extends('admin.layouts.admin')

@section('title')
{{ $title or 'Orders' }}
@stop

@section('heading')
{{ $title or 'Orders' }}
@stop

@section('admin.content')

{{-- <p>
    <a href="{{route('admin.posts.create')}}" class="btn btn-success pull-right">New Order</a>
</p> --}}

<p class="clearfix">
</p>

<?php $currentUrl = Request::url(); ?>
<div class="nav-tabs-custom">

    <ul class="nav nav-tabs">
        @foreach ( [null, 'processing', 'pending', 'completed', 'cancelled'] as $status)
        <li role="presentation" class="{{ $currentUrl === ($url = route('admin.orders.index', $status)) ? 'active' : '' }}">
            <a href="{{ $url }}">{{ ucwords($status) ?: 'All' }}</a>
        </li>
        @endforeach
    </ul>

    <div class="tab-content">
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
              <a href="{{ route('admin.orders.show', $order) }}"><strong>#{{ $order->id }}</strong></a> from <a href="{{ route('admin.users.edit', $order->user) }}">{{ $order->user->name }}</a><br>
              {{ $order->email }}
          </td>
          <td>{{ $order->product_items->count() }} items</td>
          <td class="small">
              @include('partials.address', ['address' => $order->shipping_address])
              <span class="text-muted">Via {{ $order->shipping_item->description }}</span>
          </td>
          <td>{{ $order->created_at }}</td>
          <td>{{ Present::money($order->amount) }}</td>
          <td>
            @if ($order->status == App\Order::PAID)
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
