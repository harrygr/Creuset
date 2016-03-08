{!! Form::open(['route' => ['admin.orders.update', $order], 'method' => 'PATCH', 'class' => 'form-inline pull-right']) !!}
<div class="form-group">
<label for="status">Update status: </label>
{!! Form::select('status', App\Order::$statuses, $order->status, ['class' => 'form-control input-sm']) !!}
    </div>
    <button type="submit" name="update-status" class="btn btn-default btn-sm"><i class="fa fa-check"></i></button>
{!! Form::close() !!}
