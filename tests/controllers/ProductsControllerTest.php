<?php

namespace Integration;

use Carbon\Carbon;
use Creuset\Product;
use Faker\Factory;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use TestCase;

class ProductsControllerTest extends TestCase
{
    use DatabaseTransactions;

    /** @test **/
    public function it_can_view_a_list_of_products()
    {
        $user = $this->loginWithUser();

        $product = factory(Product::class)->create();

        $this->visit('admin/products')
             ->see($product->name);
    }

    /** @test **/
    public function it_can_create_a_product()
    {
        $user = $this->loginWithUser();
        $this->visit('admin/products/create')->see('Create Product');

        $terms = factory('Creuset\Term', 2)->create(['taxonomy' => 'product_category']);

        $this->post('admin/products', [
            'name'         => 'nice product',
            'slug'         => 'nice-product',
            'description'  => 'lorem ipsum',
            'price'        => 62.50,
            'sale_price'   => 30,
            'stock_qty'    => 5,
            'sku'          => 'LP345',
            'published_at' => Carbon::now()->format('Y-m-d h:i:s'),
            'user_id'      => $user->id,
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
    public function it_can_update_a_product()
    {
        $user = $this->loginWithUser();
        $product = factory(Product::class)->create();
        $terms = factory('Creuset\Term', 2)->create(['taxonomy' => 'product_category']);

        $this->visit("admin/products/{$product->id}/edit")
             ->see('Edit Product');

        //dd($terms->pluck('id'));
        $this->patch("admin/products/{$product->id}", [
            'name'   => 'lorem ipsum',
            'terms'  => $terms->pluck('id')->toArray(),
            '_token' => csrf_token(), ]
        );

        $this->seeInDatabase('products', ['id' => $product->id, 'name' => 'lorem ipsum']);
        $this->seeInDatabase('termables', ['termable_id' => $product->id, 'term_id' => $terms[0]->id]);
        $this->seeInDatabase('termables', ['termable_id' => $product->id, 'term_id' => $terms[1]->id]);

        // Ensure the product has only 2 terms associated to it
        $this->assertCount(2, $product->terms);

        $this->assertRedirectedToRoute('admin.products.edit', $product);
        $this->visit('admin/products')->see('lorem ipsum');
    }
}
