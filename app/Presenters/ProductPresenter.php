<?php

namespace Creuset\Presenters;

use Illuminate\Support\HtmlString;
use Present;

class ProductPresenter extends ModelPresenter
{
    protected $modelRoute = 'products';

    /**
     * Get a delimited string of a product's categories.
     * 
     * @param string $delimiter
     * @param bool   $links     Should the categories link
     * 
     * @return HtmlString
     */
    public function categoryList($delimiter = ', ', $links = true)
    {
        $categoryNames = $links ? $this->model->product_categories->map(function ($category) {
      return sprintf('<a href="%s" title="edit %s category">%s</a>', route('admin.categories.edit', $category), $category->term, $category->term);
    }) : $this->model->product_categories->pluck('term');

        return new HtmlString($categoryNames->implode($delimiter));
    }

    /**
     * Get a string representing the product's price, taking into account any sale price.
     * 
     * @return HtmlString
     */
    public function price()
    {
        if (!$this->model->sale_price) {
            return new HtmlString(Present::money($this->model->price));
        }

        return new HtmlString(sprintf(
      '<del>%s</del><br> %s',
      Present::money($this->model->price),
      Present::money($this->model->sale_price)
      ));
    }

    /**
     * Get an html img tag for the product's thumbnail.
     * 
     * @param int $w The desired width of the thumbnail
     * @param int $h The desired height of the thumbnail
     * 
     * @return HtmlString
     */
    public function thumbnail($w = 300, $h = null)
    {
        $h = $h ?: $w;

        return new HtmlString(sprintf(
      '<img src="%s" alt="%s" width="%s" height="%s" class="img-responsive">',
      $this->thumbnail_url($w, $h),
      $this->model->name,
      $w,
      $h
      ));
    }

    /**
     * Get the URL of the product's thumbnail, or a placeholder if one doesn't exist.
     * 
     * @param int $w The desired width of the thumbnail
     * @param int $h The desired height of the thumbnail
     * 
     * @return string
     */
    public function thumbnail_url($w = 300, $h = null)
    {
        $h = $h ?: $w;

        return $this->model->image ? $this->model->image->thumbnail_url : "http://placehold.it/$w/$h";
    }

    /**
     * Get a string representing the stock of the product.
     * 
     * @return string
     */
    public function stock()
    {
        return $this->model->stock_qty > 0 ? sprintf('%s in stock', $this->model->stock_qty) : 'Out of stock';
    }
}
