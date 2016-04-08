<?php

namespace App\Http\Requests\Post;

class UpdatePostRequest extends PostRequest
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

    public function forbiddenResponse()
    {
        return $this->redirector->back()
        ->with('alert-class', 'danger')
        ->with('alert', 'You are not allowed to edit this post');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        return [
            'slug'            => 'alpha_dash|unique:posts,slug,'.$this->route('post')->id,
            'published_at'    => 'date',
            'status'          => 'alpha_dash',
            'type'            => 'alpha_dash',
        ];
    }
}
