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
use Antvel\Categories\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();

		$this->seller = factory('Antvel\User\Models\User')->states('seller')->create()->first();
	}

	public function tests_it_shows_the_products_listing()
	{
		$products = factory(Product::class, 2)->create([
			'name' => 'iPhone 7',
			'description' => 'Phone Case',
		])->first();

		$response = $this->get('/products');

		$response
			->assertSuccessful()
			->assertSeeText($products->name)
			->assertSeeText($products->description);
	}

	/** @test */
	function an_authorized_user_can_create_new_products()
	{
		//
	}

	/** @test */
	function an_authorized_user_can_store_new_products()
	{
		$category = factory(Category::class)->create()->first();

        $this->actingAs($this->seller);

        $response = $this->post(route('items.store'), [
			'category' => $category->id,
			'name' => 'iPhone Seven',
			'description' => 'The iPhone 7',
			'cost' => 649,
			'price' => 749,
			'stock' => 5,
			'low_stock' => 1,
			'brand' => 'apple',
			'condition' => 'new',
			'features' => [
				'weight' => '10',
				'dimensions' => '5x5x5',
				'color' => 'black',
			],
			'pictures' => [
				$this->uploadFile('images/products'),
				$this->uploadFile('images/products'),
				$this->uploadFile('images/products'),
			],
        ]);

        $response->assertStatus(302);
	}

		/** @test */
	function an_authorized_user_can_edit_products()
	{
		$product = factory(Product::class)->create();

        $this->actingAs($this->seller);

        $response = $this->get(route('items.edit', [
        	'item' => $product->id
        ]));

        $response->assertSuccessful();
	}
}
