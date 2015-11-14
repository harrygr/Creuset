<?php namespace Creuset\Presenters;

use Illuminate\View\Expression;



class ImagePresenter extends Presenter {

	public function parent()
	{
		if (!$this->model->imageable) {
			return '(no parent)';
		}
		$field_name = $this->model->imageable->getImageableField();
		return $this->model->imageable->$field_name;
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

		$route_name = 'admin.' . $this->model->imageable->getTable() . '.edit';

		if (\Route::has($route_name)) {
			return route($route_name, $this->model->imageable_id);
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