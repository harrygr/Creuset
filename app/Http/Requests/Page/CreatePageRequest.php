<?php

namespace App\Http\Requests\Page;

class CreatePageRequest extends PageRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required',
            'slug'          => 'required|unique:pages,slug',
            'published_at'  => 'required|date',
            'user_id'       => 'required|integer',
            'parent_id'     => 'numeric|exists:pages,id',
        ];
    }
}
