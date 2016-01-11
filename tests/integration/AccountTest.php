<?php

namespace Integration;

use TestCase;

class AccountTest extends TestCase
{
    use \CreatesOrders;

   /** @test **/
   public function it_can_see_the_account_page()
   {
       $this->loginWithUser();
       $this->visit('/account')
            ->see('Manage Addresses');
   }

   /** @test **/
   public function it_can_view_an_order_summary_with_a_deleted_address()
   {
       $this->createOrder();

       $this->be($this->customer);

       $this->visit('/account/addresses')
             ->press('Delete')
             ->see('Address deleted');

       $this->visit("/account/orders/{$this->order->id}")
             ->see("Order #{$this->order->id}");
   }
}
