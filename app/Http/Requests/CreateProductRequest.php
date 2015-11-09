<?php

namespace Creuset\Http\Requests;

use Creuset\Http\Requests\Request;

class CreateProductRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'  => 'required',
            'slug'  => 'required|alpha_dash|unique:products,slug',
            'sku'   => 'unique:products,sku',
            'price' => 'numeric',
            'sale_price' => 'numeric',
            'stock_qty' => 'numeric',
            'user_id' => 'required|integer',
        ];
    }
}
