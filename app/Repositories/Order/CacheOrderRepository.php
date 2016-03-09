<?php

namespace App\Repositories\Order;

use App\Order;
use App\Repositories\CacheRepository;

class CacheOrderRepository extends CacheRepository implements OrderRepository
{
    /**
     * @param ProductRepository $repository
     * @param Product           $model
     */
    public function __construct(OrderRepository $repository, Order $model = null)
    {
        $this->repository = $repository;
        $this->model = $model ?: new Order();

        $this->tag = $this->model->getTable();
    }

    /**
     * Get a count of all models in the database.
     *
     * @return int
     */
    public function count($status = null)
    {
        return \Cache::tags([$this->tag])->remember("{$this->tag}.count.$status", config('cache.time'), function () use ($status) {
            return $this->repository->count($status);
        });
    }
}
