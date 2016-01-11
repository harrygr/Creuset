<?php

namespace Creuset\Presenters;

use Illuminate\Support\HtmlString;

abstract class ModelPresenter extends Presenter
{
    public function indexLinks()
    {
        if ($this->model->trashed()) {
            $html = sprintf('<a href="%s" data-method="put">Restore</a> | ', route("admin.{$this->modelRoute}.restore", [$this->model->id])).
            sprintf('<a href="%s" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Delete Permanently</a>', route("admin.{$this->modelRoute}.delete", [$this->model->id]));
        } else {
            $html = sprintf('<a href="%s">Edit</a> | ', route("admin.{$this->modelRoute}.edit", [$this->model->id])).
            sprintf('<a href="%s" data-method="delete" data-confirm="Are you sure?" class="text-danger" rel="nofollow">Trash</a>', route("admin.{$this->modelRoute}.delete", [$this->model->id]));
        }

        return new HtmlString($html);
    }
}
