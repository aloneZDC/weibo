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
}
