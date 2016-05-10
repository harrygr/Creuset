<?php

namespace App\Http\Requests\Product;

class UpdateProductRequest extends ProductRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->defaultRules(), [
            'name'       => 'string',
            'slug'       => 'alpha_dash|unique:products,slug,'.$this->route('product')->id,
            'sku'        => 'unique:products,sku,'.$this->route('product')->id,
            'user_id'    => 'integer',
        ]);
    }
}
