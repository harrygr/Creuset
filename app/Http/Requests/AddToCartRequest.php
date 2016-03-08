<?php

namespace App\Http\Requests;

use App\Repositories\Product\ProductRepository;

class AddToCartRequest extends Request
{
    private $products;

    private $qty_in_cart = 0;
    private $qty_in_stock = 0;
    private $available_quantity;

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
        $this->available_quantity = $this->getAvailableQuantity();

        return [
        'quantity' => "integer|between:1,{$this->available_quantity}",
        ];
    }

    /**
     * Get the messages for any validation errors.
     *
     * @return array
     */
    public function messages()
    {
        $message = $this->qty_in_cart ?
            sprintf('There are %s in stock and you already have %s in your cart.', $this->qty_in_stock, $this->qty_in_cart)
            : sprintf('There are only %s in stock.', $this->qty_in_stock);

        return [
        'between' => 'You cannot add that amount to the cart. '.$message,
        ];
    }

    /**
     * Get the max qty of a product that can be added to a cart,
     * taking into account the amount number already in a cart.
     *
     * @return int
     */
    protected function getAvailableQuantity()
    {
        $this->qty_in_stock = $this->products->fetch($this->product_id)->stock_qty;

        if ($row_id = \Cart::search(['id' => (int) $this->product_id])) {
            $this->qty_in_cart = \Cart::get($row_id[0])->qty;

            return $this->qty_in_stock - $this->qty_in_cart;
        }

        return $this->qty_in_stock;
    }
}
