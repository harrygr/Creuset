<?php

use Creuset\Role;
use Creuset\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $roles = $this->seedRoles();

        // Make a pre-defined user so we can log into the application and play around
        $admin = User::create([
            'name'        => 'Harry G',
            'username'    => 'harryg',
            'email'       => 'harry@laravel.com',
            'password'    => Hash::make('secret'),
            ]);

        $admin->assignRole('admin');

        // Make some auto-generated users for extra usage
        $users = array_map(function ($i) use ($roles) {
                $user = factory('Creuset\User')->create();

                $role = $roles[array_rand($roles)];
                return $user->assignRole($role->name);
            }, range(1, 4));
    }

    private function seedRoles()
    {
        $roles = [
            'customer',
            'subscriber',
            'contributor',
            'admin',
        ];

        return array_map(function ($role) {
            return factory(Role::class)->create([
            'name'         => $role,
            'display_name' => ucwords($role),
            ]);
        }, $roles);
    }
}
