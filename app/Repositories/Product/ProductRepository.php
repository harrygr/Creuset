<?php


namespace Creuset\Repositories\Product;

interface ProductRepository
{
    /**
     * @param int   $id
     * @param array $with
     *
     * @return mixed
     */
    public function fetch($id, $with = []);

    public function all($with = []);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes);
}
