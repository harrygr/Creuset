<?php

namespace App\Http\Requests\ProductAttribute;

use App\Http\Requests\Request;

class CreateProductAttributeRequest extends Request
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
        $this->merge(['property_slug' => $this->get('property_slug', str_slug($this->get('property')))]);

        // dd($this->all());
        $slug = $this->get('slug', str_slug($this->get('name')));

        return [
            'property'      => 'required|unique:product_attributes,property,NULL,id,slug,'.$slug, // property is only unique for a given attribute
            'property_slug' => 'required|unique:product_attributes,property_slug,NULL,id,slug,'.$slug, // property slug is only unique for a given attribute
            'name'          => 'required',
            'order'         => 'numeric',
        ];
    }
}
