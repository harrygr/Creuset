<?php


namespace Creuset\Repositories\Order;

use Creuset\Order;
use Creuset\Repositories\DbRepository;

class DbOrderRepository extends DbRepository implements OrderRepository
{
    public function __construct(Order $order)
    {
        $this->model = $order;
    }

    public function count($status = null)
    {
        if (!$status) {
            return $this->model->count();
        }

        return $this->model->where('status', $status)->count();
    }
}
