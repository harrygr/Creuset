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

        return new Expression(sprintf(
                              '<del>&pound;%s</del><br> &pound;%s', 
                              $this->model->price, 
                              $this->model->sale_price
                              ));
    }

    public function thumbnail($w = 300, $h = null)
    {
        if(!$h) $h = $w;

        return new Expression(sprintf(
                              '<img src="%s" alt="%s" width="%s" height="$s">',
                              $this->model->image ? $this->model->image->thumbnail_url : "http://placehold.it/$w/$h",
                              $this->model->name,
                              $w,
                              $h
                              ));
    }

    public function stock()
    {
        return $this->model->stock_qty > 0 ? sprintf('%s in stock', $this->model->stock_qty) : 'Out of stock';
    }
}
