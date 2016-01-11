<?php

namespace Creuset\Repositories\Product;

use Creuset\Term;

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
     * @param array $with
     *
     * @return mixed
     */
    public function getPaginated($with = []);

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function create($attributes);

    public function inCategory(Term $product_category);
}
