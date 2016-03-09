<?php

namespace App\Presenters;

use App\Exceptions\PresenterException;

trait PresentableTrait
{
    protected $presenterInstance;

    public function present()
    {
        if (!$this->presenter) {
            throw new PresenterException('Please set the protected $presenter property');
        }

        if (!class_exists($this->presenter)) {
            throw new PresenterException("The presenter class {$this->presenter} does not exist");
        }

        // Singleton presenter instance
        if (!isset($this->presenterInstance)) {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }
}
