<?php

namespace App\Repositories\Order;

interface OrderRepository
{
    /**
     * @param int   $id
     * @param array $with
     *
     * @return mixed
     */
    public function fetch($id, $with = []);

    /**
     * Get a count of all models in the database.
     *
     * @return int
     */
    public function count($status = null);
}
