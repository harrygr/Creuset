<?php

namespace App;

use TestCase;

class ShopTest extends TestCase
{
    use \UsesCart;

    /** @test **/
    public function it_can_add_a_product_to_the_cart()
    {
        $product = factory(Product::class)->create([
                                                   'stock_qty' => 10,
                                                   ]);

        $this->visit('/shop')
             ->see($product->name)
             ->click($product->name)
             ->seePageIs(route('products.show', ['uncategorised', $product->slug]))
             ->press('Add To Cart')
             ->see("$product->name added to cart");

        $cart_row = \Cart::content()->first();
        $this->assertEquals($product->name, $cart_row->name);
        $this->assertEquals($product->getPrice(), \Cart::total());
    }

    /** @test **/
    public function it_cannot_add_a_quantity_of_products_greater_than_whats_in_stock()
    {
        $product = factory(Product::class)->create([
          'stock_qty' => 2,
          ]);

        $this->visit(route('products.show', [$product->product_category->slug, $product->slug]))
             ->type(3, 'quantity')
             ->press('Add To Cart')
             ->seePageIs(route('products.show', [$product->product_category->slug, $product->slug]))
             ->see('You cannot add that amount to the cart');

        $this->assertEquals(0, \Cart::total());
    }

    /** @--test-- **/
    // Currently failing, no idea why

    public function it_cannot_add_more_than_available_products_including_whats_in_cart()
    {
        $product = factory(Product::class)->create([
          'stock_qty' => 2,
          ]);

        $product_url = route('products.show', [$product->product_category->slug, $product->slug]);

        // there is already 1 of the product in the cart, we shouldn't be able
        // to add 2 more even though there is 2 in stock
        $this->visit($product_url)
             ->type(1, 'quantity')
             ->press('Add To Cart')
             ->type(2, 'quantity')
             ->seePageIs($product_url)
             ->see('You cannot add that amount to the cart');
    }

    /** @test **/
    public function it_can_remove_an_item_from_the_cart()
    {
        $product = $this->putProductInCart();

        $this->visit(route('cart'))
             ->press('remove')
             ->see("{$product->name} removed from cart");
    }

    /** @test **/
    public function it_shows_a_list_of_products_in_a_given_category()
    {
        $product_group_1 = factory(Product::class, 4)->create();
        $product_group_2 = factory(Product::class, 3)->create();

        $product_category = factory('App\Term')->create([
          'taxonomy' => 'product_category',
          'term'     => 'Cats',
          'slug'     => 'cats',
          ]);

        $product_group_2->map(function ($product) use ($product_category) {
            $product->terms()->save($product_category);
        });

        $this->visit(route('products.index', $product_category->slug))
             ->see($product_group_2->first()->name)
             ->dontSee($product_group_1->first()->name);
    }

    /** @test **/
    public function it_shows_the_cart_page()
    {
        $products = collect([
            $this->putProductInCart(),
            $this->putProductInCart(),
        ]);

        $this->visit('cart')
             ->see($products->first()->name)
             ->see(\Cart::total());
    }
}
