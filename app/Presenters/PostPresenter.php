<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

class PostPresenter extends ModelPresenter
{
    public function categoryList($delimiter = ', ', $links = true)
    {
        $categoryNames = $links ? $this->model->categories->map(function ($category) {
            return sprintf('<a href="%s" title="edit %s category">%s</a>', route('admin.categories.edit', $category), $category->term, $category->term);
        }) : $this->model->categories->pluck('term');

        return new HtmlString($categoryNames->implode($delimiter));
    }

    private $statusClasses = [
    'published'    => 'success',
    'draft'        => 'warning',
    'private'      => 'danger',
    'pending'      => 'info',
    ];

    public function statusLabel()
    {
        $status = strtolower($this->model->status);

        $labelClass = array_get($this->statusClasses, $status, 'default');

        return new HtmlString(sprintf("<span class='label label-%s pull-right'>%s</span>", $labelClass, ucfirst($status)));
    }
}
