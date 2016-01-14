{!! Form::open(['route' => ['admin.orders.update', $order], 'method' => 'PATCH', 'class' => 'form-inline pull-right']) !!}
<div class="form-group">
<label for="status">Update status: </label>
{!! Form::select('status', [
        Creuset\Order::PENDING =>Creuset\Order::PENDING,
        Creuset\Order::PAID =>Creuset\Order::PAID,
        Creuset\Order::COMPLETED =>Creuset\Order::COMPLETED,
        Creuset\Order::REFUNDED =>Creuset\Order::REFUNDED,
        Creuset\Order::CANCELLED =>Creuset\Order::CANCELLED,
    ], null, ['class' => 'form-control input-sm']) !!}
    </div>
    <button type="submit" name="complete-order" class="btn btn-default btn-sm"><i class="fa fa-check"></i></button>
{!! Form::close() !!}