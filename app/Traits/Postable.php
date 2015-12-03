<?php

namespace Creuset\Traits;

trait Postable {

    public function getEditUri()
    {
        return route('admin.' . $this->getTable() . '.edit', $this->id);
    }
}