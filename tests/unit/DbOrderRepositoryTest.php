<?php

namespace Creuset\Repositories\Order;

use Creuset\Order;
use TestCase;

class DbUserRepositoryTest extends TestCase
{
    private $orders;

    public function setUp()
    {
        parent::setUp();
        $this->orders = app(DbOrderRepository::class);
    }

    /** @test **/
    public function it_counts_the_orders()
    {
        factory(Order::class, 2)->create(['status' => Order::PAID]);
        factory(Order::class, 3)->create(['status' => Order::COMPLETED]);

        $this->assertEquals(5, $this->orders->count());
        $this->assertEquals(3, $this->orders->count(Order::COMPLETED));
    }
}
