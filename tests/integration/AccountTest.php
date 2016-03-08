<?php

namespace Integration;

use App\User;
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

    /** @test **/
    public function it_can_update_a_user_account()
    {
        $user = $this->loginWithUser();

        $this->visit('/account/edit')
        ->type('Joe Bloggs', 'name')
        ->type('joe@example.com', 'email')
        ->press('Update Account')
        ->seePageIs('/account')
        ->see('Profile updated');

        $this->seeInDatabase('users', ['id' => $user->id, 'email' => 'joe@example.com']);
    }

    /** @test **/
    public function it_cannot_update_another_user()
    {
        $other_user = factory(User::class)->create();

        $user = $this->loginWithUser();

        $this->patch(route('accounts.update', $other_user), ['email' => 'bad@email.com']);
        $this->assertResponseStatus(403);

        $this->notSeeInDatabase('users', ['id' => $other_user->id, 'email' => 'bad@email.com']);
    }
}
