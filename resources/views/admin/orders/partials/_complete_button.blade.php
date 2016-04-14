{!! Form::open(['route' => ['admin.orders.update', $order], 'method' => 'PATCH']) !!}
    <input name="status" type="hidden" value="{{ App\Order::COMPLETED }}">
    <button type="submit" name="complete-order" class="btn btn-default"><i class="fa fa-check"></i></button>
{!! Form::close() !!}
