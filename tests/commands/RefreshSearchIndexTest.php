<?php

use App\Product;

class RefreshSearchIndexTest extends TestCase
{
    /** @test */
    public function it_refreshes_products_in_the_index()
    {
        $products = factory(Product::class, 4)->create();

        \SearchIndex::shouldReceive('upsertToIndex')->times(4);

        Artisan::call('search:refresh-index', ['model' => '\App\Product']);
        $this->assertContains('entities refreshed', Artisan::output());
    }

    /** @test */
    public function it_provides_feedback_for_invalid_model()
    {
        Artisan::call('search:refresh-index', ['model' => 'bleugh!']);
        $this->assertContains('is not a searchable model', Artisan::output());

        Artisan::call('search:refresh-index', ['model' => '\App\Role']); //Roles are not searchable
        $this->assertContains('is not a searchable model', Artisan::output());
    }
}
