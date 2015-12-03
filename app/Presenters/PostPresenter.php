<?php

namespace Creuset\Presenters;

use Illuminate\View\Expression;

class PostPresenter extends ModelPresenter
{
    protected $modelRoute = 'posts';

    public function categoryList($delimiter = ', ', $links = true)
    {
        $categoryNames = $links ? $this->model->categories->map(function ($category) {
            return sprintf('<a href="%s" title="edit %s category">%s</a>', route('admin.categories.edit', $category), $category->term, $category->term);
        }) : $this->model->categories->pluck('term');

        return new Expression($categoryNames->implode($delimiter));
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

        return new Expression(sprintf("<label class='label label-%s pull-right'>%s</label>", $labelClass, ucfirst($status)));
    }
}
