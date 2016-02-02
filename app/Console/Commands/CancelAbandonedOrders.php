<?php

namespace Creuset\Console\Commands;

use Creuset\Order;
use Illuminate\Console\Command;

class CancelAbandonedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:cancel-abandoned';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mark all pending orders of a certain age as cancelled';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $abandoned_orders = Order::abandoned();

        $abandoned_orders->update(['status' => Order::CANCELLED]);

        $this->comment(sprintf('%s abandoned orders marked cancelled.', $abandoned_orders->count()));
    }
}
