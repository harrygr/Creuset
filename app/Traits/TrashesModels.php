<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait TrashesModels
{
    /**
     * Remove the specified resource from storage.
     *
     * @param Model $model
     *
     * @throws \Exception
     *
     * @return Response
     *
     * @internal param int $id
     * @internal param Request $request
     */
    public function destroy(Model $model)
    {
        $model_name = ucwords(class_basename($model));

        $alert = "$model_name moved to trash";

        if ($model->trashed()) {
            $alert = "$model_name permanently deleted";
        }

        $this->delete($model);

        return redirect()->to($this->getIndexUrl())
            ->with(['alert' => $alert, 'alert-class' => 'success']);
    }

    protected function delete(Model $model)
    {
        if ($model->trashed()) {
            return $model->forceDelete();
        }

        return $model->delete();
    }

    /**
     * Get the URL to the index page for the model.
     *
     * @return string
     */
    protected function getIndexUrl()
    {
        return property_exists($this, 'index_url') ? $this->index_url : route('admin.posts.index');
    }
}
