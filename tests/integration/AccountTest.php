<?php

namespace Integration;

use Creuset\User;
use TestCase;

class AccountTest extends TestCase
{
   /** @test **/
   public function it_can_see_the_account_page()
   {
        $this->loginWithUser();
       $this->visit('/account')
            ->see('Manage Addresses');
   }
}
