<?php

namespace App\Presenters;

use Illuminate\Support\HtmlString;

abstract class ModelPresenter extends Presenter
{
    /**
     * Get a set of edit and delete links for a model.
     *
     * @return HtmlString
     */
    public function indexLinks()
    {
        $route = $this->getModelRoute();

        if ($this->model->trashed()) {
            $html = sprintf('<a href="%s" data-method="put">Restore</a> | ', route("admin.{$route}.restore", [$this->model->id])).
            sprintf('<a href="%s" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Delete Permanently</a>', route("admin.{$route}.delete", [$this->model->id]));
        } else {
            $html = sprintf('<a href="%s">Edit</a> | ', route("admin.{$route}.edit", [$this->model->id])).
            sprintf('<a href="%s" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Trash</a>', route("admin.{$route}.delete", [$this->model->id]));
        }

        return new HtmlString($html);
    }

    protected function getModelRoute()
    {
        return $this->model->getTable();
    }
}
