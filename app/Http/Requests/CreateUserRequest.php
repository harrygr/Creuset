<?php

namespace App\Http\Requests;

class CreateUserRequest extends UserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $currentUser = auth()->user();

        return $currentUser->hasRole('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->sanitize();

        $user = $this->route('user');

        return [
            'username' => 'required|max:255|unique:users,username',
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|confirmed|min:6',
        ];
    }

    /**
     * Sanitize the input for the request.
     */
    public function sanitize()
    {
        $attributes = $this->all();
        $attributes = $this->filterEditRoles($attributes);

        $this->replace($attributes);
    }
}
