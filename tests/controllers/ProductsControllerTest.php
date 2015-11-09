<?php namespace Integration;

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
	public function it_can_create_a_product	()
	{
		$user = $this->loginWithUser();
		$this->visit('admin/products/create')->see('Create Product');

		$this->post('admin/products', [
			'name' => 'nice product',
			'slug' => 'nice-product',
			'description' => 'lorem ipsum',
			'price' => 62.50,
			'sale_price' => 30,
			'stock_qty' => 5,
			'sku' => 'LP345',
			'published_at' => Carbon::now()->format('Y-m-d h:i:s'),
			'user_id' => $user->id,
			'_token' => csrf_token(),
			]);

		$this->assertRedirectedTo('admin/products');

		$this->seeInDatabase('products', [
			'slug' => 'nice-product',
			'price' => 6250,
			'sale_price' => 3000,
			'sku' => 'LP345',
			]);
	}

	/** @test **/
	public function it_can_update_a_product()
	{
		$user = $this->loginWithUser();
		$product = factory(Product::class)->create();

		$this->visit("admin/products/{$product->id}/edit")
		     ->see("Edit Product");

		$this->patch("admin/products/{$product->id}", ['name' => 'lorem ipsum', '_token' => csrf_token()]);

		$this->seeInDatabase('products', ['id' => $product->id, 'name' => 'lorem ipsum']);
		$this->assertRedirectedTo('admin/products');
		$this->visit('admin/products')->see('lorem ipsum');
	}	
}
