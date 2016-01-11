<?php

namespace Creuset\Presenters;

abstract class Presenter
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function __get($property)
    {
        if (!method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->model->{$property};
    }

    public static function money($value)
    {
        return money_format(config('shop.currency_symbol') . '%i', $value);
    }

    public static function unslug($string)
    {
        return str_replace('_', ' ', str_replace('-', ' ', $string));
    }
}
