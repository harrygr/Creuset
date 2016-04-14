<?php

namespace App\Mailers;

use App\Product;
use App\User;

class ProductMailer extends Mailer
{
    /**
     * Send an out of stock notification to the shop admins.
     *
     * @param Product $product
     *
     * @return void
     */
    public function sendOutOfStockNotificationFor(Product $product)
    {
        $subject = 'Product out of stock: '.$product->sku;
        $view = 'emails.products.out_of_stock';

        $admins = User::shopAdmins()->get();

        foreach ($admins as $admin) {
            $this->sendTo($admin, $subject, $view, ['product' => $product]);
        }
    }

    /**
     * Send an low stock notification to the shop admins.
     *
     * @param Product $product
     *
     * @return void
     */
    public function sendLowStockNotificationFor(Product $product)
    {
        $subject = 'Product stock low_stock: '.$product->sku;
        $view = 'emails.products.low_stock';

        $admins = User::shopAdmins()->get();

        foreach ($admins as $admin) {
            $this->sendTo($admin, $subject, $view, ['product' => $product]);
        }
    }
}
