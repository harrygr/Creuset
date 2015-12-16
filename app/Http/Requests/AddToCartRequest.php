<?php

namespace Creuset\Http\Requests;

use Creuset\Http\Requests\Request;
use Creuset\Repositories\Product\ProductRepository;

class AddToCartRequest extends Request
{
    private $products;



    public function __construct(ProductRepository $products)
    {
        $this->products = $products;
    }


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
        $product = $this->products->fetch($this->product_id);

        return [
        'quantity' => "integer|between:1,{$product->stock_qty}"
        ];
    }

    public function messages()
    {
        return [
        'between' => 'You cannot add that amount to the cart because there is not enough stock',
        ];
    }
}
