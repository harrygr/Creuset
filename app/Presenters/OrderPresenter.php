<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class OrderPresenter extends ModelPresenter
{
    private $statusClasses = [
    'pending'     => 'warning',
    'processing'  => 'primary',
    'completed'   => 'success',
    'refunded'    => 'default',
    'cancelled'   => 'danger',
    ];

    /**
     * Present the order status as a coloured label or text.
     *
     * @param bool $text Whether to display as a test instead of a label
     *
     * @return \Illuminate\Support\HtmlString;
     */
    public function status($text = false)
    {
        $status = $this->model->status;
        $label_class = array_get($this->statusClasses, $status, 'default');

        $class = $text ? "text-{$label_class}" : "label label-{$label_class}";

        return new HtmlString(
            sprintf("<span class='%s'>%s</span>", $class, \Present::labelText($status))
            );
    }
}
