<?php

use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    use DatabaseMigrations, DatabaseTransactions;

    protected $baseUrl;

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        $this->baseUrl = \Config::get('app.url', 'http://homestead.app');

        $this->setUpDatabase();

        return $app;
    }

    protected function setUpDatabase()
    {
        Artisan::call('migrate:refresh');
    }

    protected function logInAsAdmin(array $overrides = [])
    {
        return $this->loginWithUser($overrides, 'admin');
    }

    protected function loginWithUser(array $overrides = [], $role = 'subscriber')
    {
        $user = factory('App\User')->create($overrides);

        $user->assignRole($this->getRole($role)->name);

        $this->be($user);

        return $user;
    }

    protected function getRole($role_name)
    {
        $role = App\Role::where('name', $role_name)->first();
        if (!$role) {
            return App\Role::create([
                'name'         => $role_name,
                'display_name' => ucwords($role_name),
                ]);
        }

        return $role;
    }

    protected function createImage($quantity = 1)
    {
        // Make a post
        $post = factory('App\Post')->create();
        $faker = Factory::create();
        $image = base_path('tests/resources/images/image-1.jpg');

        // And we need a file
        foreach (range(1, $quantity) as $creation) {
            $image_name = $faker->bothify('??#?#??').'.jpg';
            $file = new UploadedFile($image, $image_name, null, null, null, true);
            $post->addMedia($file)->preservingOriginal()->toMediaLibrary();
        }

        return $quantity > 1 ? $post->getMedia() : $post->getMedia()->first();
    }
}
