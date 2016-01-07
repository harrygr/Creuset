<?php

namespace Creuset\Presenters;

use Illuminate\View\Expression;
use Present;

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
            return new Expression(Present::money($this->model->price));
        }

        return new Expression(sprintf(
      '<del>%s</del><br> %s',
      Present::money($this->model->price),
      Present::money($this->model->sale_price)
      ));
    }

    public function thumbnail($w = 300, $h = null)
    {
        return new Expression(sprintf(
      '<img src="%s" alt="%s" width="%s" height="$s" class="img-responsive">',
      $this->thumbnail_url($w, $h),
      $this->model->name,
      $w,
      $h
      ));
    }

    public function thumbnail_url($w = 300, $h = null)
    {
        if (!$h) {
            $h = $w;
        }

        return $this->model->image ? $this->model->image->thumbnail_url : "http://placehold.it/$w/$h";
    }

    public function stock()
    {
        return $this->model->stock_qty > 0 ? sprintf('%s in stock', $this->model->stock_qty) : 'Out of stock';
    }
}
