<?php

namespace Creuset\Presenters;

use Illuminate\View\Expression;

class ProductPresenter extends ModelPresenter
{
    protected $modelRoute = 'products';

    public function categoryList($delimiter = ', ', $links = true)
    {
        $categoryNames = $links ? $this->model->product_categories->map(function ($category) {
            return sprintf('<a href="%s" title="edit %s category">%s</a>', route('admin.categories.edit', $category), $category->term, $category->term);
        }) : $this->model->product_categories->pluck('term');

        return new Expression($categoryNames->implode($delimiter));
    }

    public function price()
    {
        if (!$this->model->sale_price) {
            return new Expression("&pound;{$this->model->price}");
        }

        return new Expression(sprintf('<del>&pound;%s</del><br> &pound;%s', $this->model->price, $this->model->sale_price));
    }
}
