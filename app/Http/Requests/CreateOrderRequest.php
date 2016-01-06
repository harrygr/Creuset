<?php

namespace Creuset\Http\Requests;

use Creuset\Address;
use Creuset\Http\Requests\Request;
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
        $rules = new Collection;

        if (!$this->user() or !$this->user()->addresses()->count()) {

            $rules = $rules->merge($this->addressRules('billing'));
            if(!$this->has('shipping_same_as_billing')) {
                $rules = $rules->merge($this->addressRules('shipping'));
            }
            return $rules->toArray();
        }
        return $rules->merge([
                             'billing_address_id' => 'required|numeric',
                             'shipping_address_id' => 'required|numeric',
                             ])->toArray();
    }

    /**
     * Build up the validation rules for a given address type
     * 
     * @param  string $type The address type e.g. billing
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
