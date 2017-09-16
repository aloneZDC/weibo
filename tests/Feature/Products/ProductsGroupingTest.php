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

class ProductsGroupingTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();

		$this->seller = factory('Antvel\Users\Models\User')->states('seller')->create()->first();
	}

	/** @test */
	function an_unauthorized_user_cannot_edit_products_grouping()
	{
		$product = factory(Product::class)->create();

		$this->get(route('itemgroup.edit', $product))
			->assertRedirect(route('login'));
	}

	/** @test */
	function an_authorized_user_can_edit_products_grouping()
	{
		$productA = factory(Product::class)->create(['name' => 'Product A']);
	    $productB = factory(Product::class)->create(['name' => 'Product B']);
	    $productC = factory(Product::class)->create(['name' => 'Product C']);

		$productA->groupWith($productB, $productC);

		$response = $this->actingAs($this->seller)
			->get(route('itemgroup.edit', $productA))
			->assertSuccessful();

		tap($response->data('groupingIds'), function($ids) use ($productA, $productB, $productC) {
			$this->assertTrue($ids->contains($productB->id));
			$this->assertTrue($ids->contains($productC->id));
			$this->assertFalse($ids->contains($productA->id));
		});

		$this->assertTrue($response->data('product')->is($productA));
		$this->assertEquals('', $response->data('getQueryString'));
		$this->assertTrue((bool) $response->data('filters'));
	}

	/** @test */
	function an_unauthorized_user_cannot_update_products_grouping()
	{
		$product = factory(Product::class)->create();

		$this->patch(route('itemgroup.update', $product))
			->assertRedirect(route('login'))
			->assertStatus(302);
	}

	/** @test */
	function an_authorized_user_can_update_products_grouping()
	{
		$this->disableExceptionHandling();

		$productA = factory(Product::class)->create(['name' => 'Product A']);
	    $productB = factory(Product::class)->create(['name' => 'Product B']);
	    $productC = factory(Product::class)->create(['name' => 'Product C']);

	    $data = [
	    	'associates' => [$productB->id, $productC->id]
	    ];

	    $response = $this
	    	->actingAs($this->seller)
	    	->put(route('itemgroup.update', $productA), $data)
	    	->assertStatus(302);

	    tap($productA->fresh()->group, function ($grouping) use ($productB, $productC) {
	    	$this->assertCount(2, $grouping);
	    	$this->assertTrue($grouping->pluck('id')->contains($productB->id));
	    	$this->assertTrue($grouping->pluck('id')->contains($productC->id));
	    });
	}
}
