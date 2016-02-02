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
        $abandoned_count = $abandoned_orders->count();

        $abandoned_orders->update(['status' => Order::CANCELLED]);

        if ($abandoned_count > 0) {
            $this->info(sprintf('%s abandoned orders cancelled.', $abandoned_count));
        } else {
            $this->info('No abandoned orders to cancel.');
        }
    }
}
