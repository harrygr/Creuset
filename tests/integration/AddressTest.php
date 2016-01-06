<?php

namespace Integration;

use Creuset\Address;
use Creuset\User;
use TestCase;

class AddressTest extends TestCase
{
    /** @test **/
    public function it_shows_saved_addresses()
    {
        $user = $this->loginWithUser();
        $address = factory(Address::class)->create([
                                                   'user_id' => $user->id,
                                                   ]);
        $this->visit('account/addresses')
             ->see($address->line_1);
    }

    /** @test **/
    public function it_can_create_a_new_address()
    {
        $user = $this->loginWithUser();

        $this->visit(route('addresses.create'))
             ->type('Mr Joe Bloggs', 'name')
             ->type('0123456789', 'phone')
             ->type('11 Acacia Avenue', 'line_1')
             ->type('London', 'city')
             ->type('SW1 4NQ', 'postcode')
             ->type('United Kingdon', 'country')
             ->press('Save Address')
             ->seePageIs('/account/addresses')
             ->see('saved')->see('11 Acacia Avenue');
    }

    /** @test **/
    public function it_deletes_an_address()
    {
        $user = $this->loginWithUser();
        $address = factory(Address::class)->create([
                               'user_id' => $user->id,
                               ]);

        $this->visit("account/addresses")
             ->see($address->postcode)
             ->press('Delete')
             ->seePageIs("account/addresses")
             ->see("Address Deleted");
             //->dontSee($address->postcode); 

             $this->assertEmpty(\Creuset\User::find($user->id)->addresses);
    }

    /** @test **/
    public function it_allows_editing_an_address()
    {
        $user = $this->loginWithUser();
        $address = factory(Address::class)->create([
                               'user_id' => $user->id,
                               ]);
        $this->visit("account/addresses/{$address->id}/edit");
    }

    /** @test **/
    public function it_does_not_allow_user_to_edit_another_users_address()
    {
        $user = $this->loginWithUser();
        $user_2 = factory(User::class)->create();
        $address = factory(Address::class)->create([
                               'user_id' => $user_2->id,
                               ]);
        $this->call('GET', "account/addresses/{$address->id}/edit");
        $this->assertResponseStatus(403);
    }
}
