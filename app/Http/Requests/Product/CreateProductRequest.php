<?php

namespace App\Http\Requests\Product;

class CreateProductRequest extends ProductRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return array_merge($this->defaultRules(), [
            'sku'        => 'required|unique:products,sku',
        ]);
    }
}
