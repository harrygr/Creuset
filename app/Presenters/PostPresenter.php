<?php namespace Creuset\Presenters;

class PostPresenter extends Presenter {
	public function categoryList($delimiter = ", ")
	{
		$categoryNames = array_pluck($this->model->categories->toArray(), 'term');
		return implode($delimiter, $categoryNames);
	}
	protected $statusClasses = [
		'published'	=> 'success',
		'draft'		=> 'warning',
		'private'	=> 'danger',
	];

	public function statusLabel()
	{
		$status = strtolower($this->model->status);
		$labelClass = array_key_exists($status, $this->statusClasses) ? $this->statusClasses[$status] : 'default';
		return sprintf("<label class='label label-%s pull-right'>%s</label>",$labelClass, ucfirst($status));
	}
}