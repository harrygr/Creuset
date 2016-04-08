<?php

namespace App\Http\Requests\Page;

// use App\Http\Requests\Request;

class UpdatePageRequest extends PageRequest
{
    public function forbiddenResponse()
    {
        return $this->redirector->back()
        ->with('alert-class', 'danger')
        ->with('alert', 'You are not allowed to edit this page');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'slug'            => 'alpha_dash|unique:pages,slug,'.$this->route('page')->id,
            'published_at'    => 'date',
            'status'          => 'alpha_dash',
        ];
    }
}
