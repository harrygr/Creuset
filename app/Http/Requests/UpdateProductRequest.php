<?php

namespace Creuset\Http\Requests;

class UpdateProductRequest extends Request
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
            'slug'       => 'alpha_dash|unique:products,slug,'.$this->route('product')->id,
            'sku'        => 'unique:products,sku,'.$this->route('product')->id,
            'price'      => 'numeric',
            'sale_price' => 'numeric',
            'stock_qty'  => 'numeric',
            'user_id'    => 'integer',
            'image_id'   => 'integer',
        ];
    }
}
