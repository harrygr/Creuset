<?php

namespace App\Http\Controllers\Admin;

use App\Product;
use Carbon\Carbon;
use Faker\Factory;

class ProductsControllerTest extends \TestCase
{
    private $user;

    public function setUp()
    {
        parent::setUp();
        $this->user = $this->logInAsAdmin();
    }

    /** @test **/
    public function it_can_view_a_list_of_products()
    {
        $product = factory(Product::class)->create();

        $this->visit('admin/products')
             ->see($product->name);
    }

    /** @test **/
    public function it_can_create_a_product()
    {
        $this->visit('admin/products/create')->see('Create Product');

        $terms = factory('App\Term', 2)->create(['taxonomy' => 'product_category']);

        $this->post('admin/products', [
            'name'         => 'nice product',
            'slug'         => 'nice-product',
            'description'  => 'lorem ipsum',
            'price'        => 62.50,
            'sale_price'   => 30,
            'stock_qty'    => 5,
            'sku'          => 'LP345',
            'published_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'user_id'      => $this->user->id,
            'terms'        => $terms->pluck('id')->toArray(),
            '_token'       => csrf_token(),
            ]);

        // dd($this->response->getContent());
        // $this->assertRedirectedToRoute('admin.products.edit', 1);

        $this->seeInDatabase('products', [
            'slug'       => 'nice-product',
            'price'      => 6250,
            'sale_price' => 3000,
            'sku'        => 'LP345',
            ]);

        $product = Product::whereSlug('nice-product')->first();

        $this->seeInDatabase('termables', ['termable_id' => $product->id, 'term_id' => $terms[0]->id]);
        $this->seeInDatabase('termables', ['termable_id' => $product->id, 'term_id' => $terms[1]->id]);
    }

    /** @test **/
    public function it_validates_the_price_of_a_product()
    {
        $this->post('admin/products', [
            'name'         => 'nice product',
            'slug'         => 'nice-product',
            'description'  => 'lorem ipsum',
            'price'        => 62.50,
            'sale_price'   => 70,
            'stock_qty'    => 5,
            'sku'          => 'LP346',
            'published_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'user_id'      => $this->user->id
            ]);
    }

    /** @test **/
    public function it_can_update_a_product()
    {
        $product = factory(Product::class)->create();
        $terms = factory('App\Term', 2)->create(['taxonomy' => 'product_category']);

        $this->visit("admin/products/{$product->id}/edit")
             ->see('Edit Product');

        $this->patch("admin/products/{$product->id}", [
            'name'   => 'lorem ipsum',
            'terms'  => $terms->pluck('id')->toArray(),
            '_token' => csrf_token(),
            ]);


        $this->seeInDatabase('products', ['id' => $product->id, 'name' => 'lorem ipsum']);
        $this->seeInDatabase('termables', ['termable_id' => $product->id, 'term_id' => $terms[0]->id]);
        $this->seeInDatabase('termables', ['termable_id' => $product->id, 'term_id' => $terms[1]->id]);

        // Ensure the product has only 2 terms associated to it
        $this->assertCount(2, $product->terms);

        $this->assertRedirectedToRoute('admin.products.edit', $product);
        $this->visit('admin/products')->see('lorem ipsum');
    }

    /** @test **/
    public function it_can_delete_a_product()
    {
        $product = factory(Product::class)->create();

        $this->delete(route('admin.products.delete', $product), ['_token' => csrf_token()]);

        $this->assertRedirectedToRoute('admin.products.index');

        // assert that the product has been soft deleted
        $this->assertTrue(Product::withTrashed()->find($product->id)->trashed());
    }
}
