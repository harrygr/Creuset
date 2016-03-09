<?php

namespace App\Contracts;

/**
 * The contract for a model that has terms attached.
 */
interface Termable
{
    public function terms();
}
