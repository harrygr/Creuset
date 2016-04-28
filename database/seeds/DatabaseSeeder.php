<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    private $tables = [
        'termables',
        'terms',
        'product_attributes',
        'posts',
        'pages',
        'products',
        'users',
        'roles',
        'media',
        'shipping_methods',
        'orders',
        'order_items',
        'addresses',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();
        $this->command->getOutput()->writeln('Truncated Tables');

        Model::unguard();

        $this->call('UsersTableSeeder');
        $this->call('PostsTableSeeder');
        $this->call('PagesTableSeeder');
        $this->call('ProductsTableSeeder');
        $this->call('TermsTableSeeder');
        $this->call('ProductAttributesTableSeeder');
        $this->call('TermablesTableSeeder');
        $this->call('AddressesTableSeeder');
        $this->call('ShippingMethodsTableSeeder');
        $this->call('OrdersTableSeeder');
    }

    /**
     * Remove any data currently in the database tables.
     */
    protected function cleanDatabase()
    {
        $this->disableForeignKeyCheck();
        foreach ($this->tables as $table) {
            DB::table($table)->truncate();
        }
        $this->enableForeignKeyCheck();
    }

    protected function disableForeignKeyCheck()
    {
        $statement = $this->getForeignKeyCheckStatement();
        DB::statement($statement['disable']);
    }

    protected function enableForeignKeyCheck()
    {
        $statement = $this->getForeignKeyCheckStatement();
        DB::statement($statement['enable']);
    }

    protected function getForeignKeyCheckStatement()
    {
        $driver = \DB::connection()->getDriverName();

        if ($driver == 'sqlite') {
            return [
            'disable' => 'PRAGMA foreign_keys = OFF',
            'enable'  => 'PRAGMA foreign_keys = ON',
            ];
        }

        return [
        'disable' => 'SET FOREIGN_KEY_CHECKS=0',
        'enable'  => 'SET FOREIGN_KEY_CHECKS=1',
        ];
    }
}
