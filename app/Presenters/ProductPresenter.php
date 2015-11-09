<?php namespace Creuset\Presenters;

use Illuminate\View\Expression;

class ProductPresenter extends ModelPresenter {
	protected $modelRoute = 'products';

	public function price()
	{
		if (!$this->model->sale_price) {
			return $this->model->price;
		}

		return new Expression(sprintf('<del>%s</del><br> %s', $this->model->price, $this->model->sale_price));
	}

}