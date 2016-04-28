<?php

namespace App\Http\Requests\ProductAttribute;

use App\Http\Requests\Request;

class UpdateProductAttributeRequest extends Request
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
        $attribute = $this->route('product_attribute');
        $slug = $this->get('slug', str_slug($this->get('name')));

        return [
            'property'      => 'unique:product_attributes,property,'.$attribute->id.',id,slug,'.$slug, // property is only unique for a given attribute
            'property_slug' => 'unique:product_attributes,property_slug,'.$attribute->id.',id,slug,'.$slug, // property slug is only unique for a given attribute
            'order'         => 'numeric',
        ];
    }
}
