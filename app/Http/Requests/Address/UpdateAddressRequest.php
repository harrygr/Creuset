<?php

namespace App\Http\Requests\Address;

use App\Address;
use App\Http\Requests\Request;

class UpdateAddressRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->owns($this->address);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Address::$rules;
    }
}
