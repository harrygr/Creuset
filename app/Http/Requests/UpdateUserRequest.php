<?php

namespace Creuset\Http\Requests;

use Creuset\Http\Requests\Request;

class UpdateUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Needs work:
        return true;
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
            'username' => 'required|max:255|unique:users,username,' . $user->id,
            'email'    => 'required|email|max:255|unique:users,email,' . $user->id,
            'password' => 'confirmed|min:6'
        ];
    }

    /**
     * Sanitize the input for the request.
     *
     */
    public function sanitize()
    {
        $attributes = $this->all();

        if(!strlen($this->password))
        {
            unset($attributes['password']);
        }

       $this->replace($attributes);
    }
}
