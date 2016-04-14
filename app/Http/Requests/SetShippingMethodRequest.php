<?php

namespace App\Http\Requests;

use App\Repositories\ShippingMethod\ShippingMethodRepository;

class SetShippingMethodRequest extends Request
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
        $shipping_methods = \App::make(ShippingMethodRepository::class);

        $available_methods = $shipping_methods->forCountry($this->session()->get('order')->shipping_address->country);

        return [
            'shipping_method_id'    => 'required|integer|in:'.$available_methods->implode('id', ','),
        ];
    }

    public function messages()
    {
        return [
        'shipping_method_id.in'    => 'The shipping method chosen must be available for your chosen shipping address.',
        'shipping_method_id.*'     => 'Please choose a valid shipping method.',
       ];
    }
}
