<?php

namespace Events;

use App\Events\ProductStockChanged;
use App\Product;
use App\User;
use TestCase;

class ProductStockChangedEventTest extends TestCase
{
    use \MailTracking;

    /** @test **/
    public function it_alerts_to_a_product_being_out_of_stock()
    {
        $product = factory(Product::class)->create(['stock_qty' => 0]);

        event(new ProductStockChanged($product));

        $admin_users = User::shopAdmins()->get();
        $this->seeEmailTo($admin_users->first()->email);
    }

    /** @test **/
    public function it_alerts_to_a_low_stock_product()
    {
        $product = factory(Product::class)->create(['stock_qty' => 1]);

        event(new ProductStockChanged($product));

        $admin_users = User::shopAdmins()->get();
        $this->seeEmailTo($admin_users->first()->email);
    }
}
