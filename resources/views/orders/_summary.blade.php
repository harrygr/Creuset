<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->product_items as $item)
        <tr>
            <td>
                <a href="{{ $item->orderable->url }}">{{ $item->orderable->name }}</a> x{{ $item->quantity}}
            </td>
            <td>{{ Present::money($item->total_paid) }}</td>
        </tr>
        @endforeach
        <tr>
            <td colspan="2"></td>
        </tr>
        @foreach ($order->shipping_items as $item)
        <tr>
            <td>
                {{ $item->description }}
            </td>
            <td>{{ Present::money($item->total_paid) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right">Total</th>
            <th>{{ Present::money($order->amount) }}</th>
        </tr>
    </tfoot>
</table>
<div class="row">
    <div class="col-md-6">
        <h3>Billing Address</h3>
        @include('partials.address', ['address' => $order->billing_address])
    </div>
    <div class="col-md-6">
        <h3>Shipping Address</h3>
        @include('partials.address', ['address' => $order->shipping_address])
    </div>
</div>