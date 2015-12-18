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
        $available_quantity = $this->getAvailableQuantity();

        return [
        'quantity' => "integer|between:1,{$available_quantity}"
        ];
    }

    public function messages()
    {
        return [
        'between' => 'You cannot add that amount to the cart because there is not enough stock',
        ];
    }

    /**
     * Get the max qty of a product that can be added to a cart,
     * taking into account the amount number already in a cart.
     * @return integer
     */
    protected function getAvailableQuantity()
    {
        $qty_in_stock = $this->products->fetch($this->product_id)->stock_qty;

        if ($row_id = \Cart::search(['id' => $this->product_id])) {
            return $qty_in_stock - \Cart::get($row_id[0])->qty;
        }
        return $qty_in_stock;
    }
}
