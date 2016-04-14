<?php

namespace App\Http\Requests;

use App\Address;
use Illuminate\Support\Collection;

class CreateOrderRequest extends Request
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
        $rules = new Collection();

        if (!$this->user() or !$this->user()->addresses()->count()) {
            $rules = $rules->merge($this->addressRules('billing'));
            if ($this->has('different_shipping_address')) {
                $rules = $rules->merge($this->addressRules('shipping'));
            }

            return $rules->toArray();
        }

        return $rules->merge([
                             'billing_address_id'  => 'required|numeric',
                             'shipping_address_id' => 'required|numeric',
                             ])->toArray();
    }

    public function messages()
    {
        $messages = collect([
            'billing_address_id.required'  => 'Please pick a billing address.',
            'shipping_address_id.required' => 'Please pick a shipping address.',
            ]);

        foreach (Address::$rules as $field => $rule) {
            $messages->put("billing_address.$field.required", sprintf('The billing address %s is required.', str_replace('_', ' ', $field)));
            $messages->put("shipping_address.$field.required", sprintf('The shipping address %s is required.', str_replace('_', ' ', $field)));
        }

        return $messages->toArray();
    }

    /**
     * Build up the validation rules for a given address type.
     *
     * @param string $type The address type e.g. billing
     *
     * @return Illuminate\Support\Collection
     */
    protected function addressRules($type)
    {
        $rules = collect([]);

        foreach (Address::$rules as $field => $rule) {
            $rules->put("{$type}_address.$field", $rule);
        }

        return $rules;
    }
}
