<?php namespace Creuset\Presenters;

use Illuminate\View\Expression;



class ImagePresenter extends Presenter {

	public function parent($attribute = 'title')
	{
		if (!$this->model->imageable) {
			return '(no parent)';
		}

		return $this->model->imageable->$attribute;
	}

	/**
	 * Get the URL to edit the parent of the image
	 * @return string|boolean The full url to the edit page. False on failure
	 */
	public function parentUrl()
	{
		if (!$this->model->imageable) {
			return false;
		}

		$routeName = 'admin.' . $this->model->imageable->getTable() . '.edit';

		if (\Route::has($routeName)) {
			return route($routeName, $this->model->imageable_id);
		}

		return false;
	}

	public function owner($attribute = 'name')
	{
		if ($this->model->user) {
			return $this->model->user->$attribute;
		}

		return '(no owner)';
	}

	public function title()
	{
		$link = sprintf('<a href="%s" title="Permalink">%s</a>', $this->model->url(), basename($this->model->path));
		if ($this->model->title) {
			return new Expression(sprintf("<strong>%s</strong><br>%s",  $this->model->title, $link));
		}

		return new Expression($link);
	}
}