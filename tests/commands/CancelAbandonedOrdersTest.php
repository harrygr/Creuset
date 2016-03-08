<?php

use App\Order;

class CancelAbandonedOrdersTest extends TestCase
{
    /** @test */
    public function it_cancels_all_abanded_orders()
    {
        $abandoned_orders = factory(Order::class, 2)->create([
            'status'     => Order::PENDING,
            'updated_at' => \Carbon\Carbon::parse('10 hours ago'),
            ]);

        $completed_order = factory(Order::class)->create([
            'status'     => Order::COMPLETED,
            'updated_at' => \Carbon\Carbon::parse('13 hours ago'),
            ]);

        $in_progress_order = factory(Order::class)->create([
            'status'     => Order::PENDING,
            'updated_at' => \Carbon\Carbon::parse('1 minute ago'),
            ]);

        $this->assertEquals(2, Order::abandoned()->count());

        Artisan::call('orders:cancel-abandoned');
        $this->assertContains('2 abandoned orders cancelled', Artisan::output());

        $this->assertEquals(0, Order::abandoned()->count());
        $this->assertEquals(2, Order::where('status', Order::CANCELLED)->count());
    }
}
