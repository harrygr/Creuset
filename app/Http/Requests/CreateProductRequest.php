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
            'sku'   => 'required|unique:products,sku',
            'price' => 'numeric|min:0',
            'sale_price' => 'numeric|min:0',
            'stock_qty' => 'numeric',
            'user_id' => 'required|integer',
            'image_id' => 'integer',
        ];
    }
}
