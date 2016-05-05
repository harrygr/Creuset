<?php

namespace App\Presenters;

abstract class Presenter
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return $this->model->{$property};
    }

    /**
     * Present a numeric value as a money string, according to the site settings.
     *
     * @param float $value The value to present
     *
     * @return string
     */
    public static function money($value)
    {
        return money_format(config('shop.currency_symbol').'%i', $value);
    }

    /**
     * Convert a slug to a space-separated string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function unslug($string)
    {
        return str_replace('_', ' ', str_replace('-', ' ', $string));
    }

    /**
     * Convert a slug to a proper cased string.
     *
     * @param string $string
     *
     * @return string
     */
    public static function labelText($string)
    {
        return ucwords(static::unslug($string));
    }
}
