<?php namespace Creuset\Presenters;

use Illuminate\View\Expression;

class PostPresenter extends Presenter {

	public function categoryList($delimiter = ", ", $links = true)
	{
		$categoryNames = $links ? $this->model->categories->map(function($category)
		{
			return sprintf('<a href="%s" title="edit %s category">%s</a>', route('admin.categories.edit', $category), $category->term, $category->term);
		}) : $this->model->categories->pluck('term');

		return new Expression($categoryNames->implode($delimiter));
	}

	private $statusClasses = [
	'published'	=> 'success',
	'draft'		=> 'warning',
	'private'	=> 'danger',
	'pending'	=> 'info',
	];

	public function statusLabel()
	{
		$status = strtolower($this->model->status);

		$labelClass = array_get($this->statusClasses, $status, 'default');
		return new Expression(sprintf("<label class='label label-%s pull-right'>%s</label>", $labelClass, ucfirst($status)));
	}

	public function indexLinks()
	{
		if ($this->model->trashed()) {
			$html = sprintf('<a href="%s" data-method="put">Restore</a> | ', route('admin.posts.restore', [$this->model->id])) . 
			sprintf('<a href="%s" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Delete Permanently</a>', route('admin.posts.delete', [$this->model->id]));
		} else {
			$html = sprintf('<a href="%s">Edit</a> | ', route('admin.posts.edit', [$this->model->id])) . 
			sprintf('<a href="%s" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Trash</a>', route('admin.posts.delete', [$this->model->id]));
		}
		return new Expression($html);
	}
}