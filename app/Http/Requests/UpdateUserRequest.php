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
        $currentUser = auth()->user();

        return $this->route('user')->id == $currentUser->id or $currentUser->hasRole('admin');
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
        $attributes = $this->filterEditRoles($attributes);

        if(!strlen($this->password))
        {
            unset($attributes['password']);
        }

       $this->replace($attributes);
    }

    /**
     * If a user is not permissioned to update roles we'll remove this bit from the request
     * @param  array $attributes The request attributes
     * @return array             The filtered attributes
     */
    protected function filterEditRoles($attributes)
    {
        if (!auth()->user()->hasRole('admin') and isset($attributes['role_id']))
        {
            unset($attributes['role_id']);
        }
        return $attributes;
    }
}
