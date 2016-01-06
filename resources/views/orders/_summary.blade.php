<table class="table">
    <thead>
        <tr>
            <th>Product</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($order->items as $item)
        <tr>
            <td>
                <a href="{{ $item->orderable->url }}">{{ $item->orderable->name }}</a> x{{ $item->quantity}}
            </td>
            <td>{{ $item->price_paid }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right">Total</th>
            <th>{{ $order->amount }}</th>
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