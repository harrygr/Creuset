<?php

namespace App\Http\Requests\Page;

use App\Http\Requests\Request;

class PageRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // We'll allow users to edit each other's posts for now
        // Maybe add some role-based authorization at some point
        return true;
    }

    public function messages()
    {
        return [
            'parent_id.not_in' => 'You cannot make a page a child of itself or its children.',
            'parent_id.exists' => 'The parent page you have selected does not exist.',
        ];
    }
}
