<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Feature\Products;

use Tests\TestCase;
use Antvel\Product\Models\Product;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	function it_shows_the_products_listing()
	{
		$productA = factory(Product::class)->create(['name' => 'foo','description' => 'bar'])->first();
		$productB = factory(Product::class)->create(['name' => 'biz','description' => 'sas'])->first();

		$this->get('/products')
			->assertSuccessful()
			->assertSeeText($productA->name)
			->assertSeeText($productA->description)
			->assertSeeText($productB->name)
			->assertSeeText($productB->description);
	}

	/** @test */
	function it_can_show_a_given_product()
	{
		$product = factory(Product::class)->create();

		$response = $this->get('/products/' . $product->id);

		$response
			->assertSuccessful()
			->assertSeeText($product->name)
			->assertSeeText($product->description);
	}

	/** @test */
	function update_signed_user_preferences_when_showing_a_given_product_details()
	{
		$this->actingAs(
			$user =  factory('Antvel\Users\Models\User')->create()->first()
		);

		$this->assertSame('', trim($user->preferences['product_viewed']));

		$product = factory(Product::class)->create();

		$this->get('/products/' . $product->id)->assertSuccessful();

		$this->assertSame($user->preferences['product_viewed'], $product->tags);
		$this->assertSame('', trim($user->preferences['product_categories']));
		$this->assertSame('', trim($user->preferences['product_purchased']));
		$this->assertSame('', trim($user->preferences['product_shared']));
		$this->assertSame('', trim($user->preferences['my_searches']));
	}
}
