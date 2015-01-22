<?php namespace Creuset\Presenters;

class PostPresenter extends Presenter {
	public function categoryList($delimiter = ", ")
	{
		$categoryNames = array_pluck($this->model->categories->toArray(), 'term');
		return implode($delimiter, $categoryNames);
	}
}