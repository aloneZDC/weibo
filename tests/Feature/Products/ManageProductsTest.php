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
use Illuminate\Http\UploadedFile;
use Antvel\Product\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ManageProductsTest extends TestCase
{
	use DatabaseMigrations;

	public function setUp()
	{
		parent::setUp();

		$this->category = factory('Antvel\Categories\Models\Category')->create([
			'name' => 'Category Name'
		])->first();

		$this->seller = factory('Antvel\Users\Models\User')->states('seller')->create()->first();
	}

	protected function validaData($attributes = [])
	{
		return array_merge($attributes, [
			'category' => $this->category->id,
			'name' => 'New name',
			'description' => 'New description',
			'cost' => '6.49',
			'price' => '7.49',
			'stock' => 5,
			'low_stock' => 1,
			'brand' => 'New brand',
			'condition' => 'new',
			'status' => true,
			'features' => [
				'weight' => 'New weight',
				'dimensions' => 'New dimensions',
				'color' => 'New color',
			],
		]);
	}

	/** @test */
	function an_unauthorized_user_cannot_see_seller_products_listing()
	{
		$this->get(route('items.index'))->assertRedirect(route('login'));
	}

	/** @test */
	function an_authorized_user_can_see_seller_products_listing()
	{
		$product = factory(Product::class)->create(['name' => 'foo', 'category_id' => $this->category->id])->first();

		$this->actingAs($this->seller)
			->get(route('items.index'))
			->assertSuccessful()
			->assertSeeText($product->name)
			->assertSeeText($product->category->name);
	}

	/** @test */
	function an_unauthorized_user_is_not_able_to_publish_new_products()
	{
		$this->post(route('items.store'), $this->validaData())
			->assertRedirect(route('login'))
			->assertStatus(302);

		$this->assertCount(0, Product::get());
	}

	/** @test */
	function an_authorized_user_can_see_products_creation_form()
	{
		$this->actingAs($this->seller)->get(route('items.create'))->assertSuccessful();
	}

	/** @test */
	function an_authorized_user_can_store_new_products()
	{
		Storage::fake('images/products');

		$data = $this->validaData([
			'pictures' => [
				'storing' => [
					UploadedFile::fake()->image('foo.jpg'),
					UploadedFile::fake()->image('bar.jpg'),
				]
			]
		]);

		$response = $this->actingAs($this->seller)
			->post(route('items.store'), $data)
			->assertStatus(302);

		$product = Product::first();

		$response->assertRedirect(route('items.edit', [
			'id' => $product->id
		]));

		$this->assertEquals(1, $this->category->id);
		$this->assertEquals('New name', $product->name);
		$this->assertEquals('New description', $product->description);
		$this->assertEquals(649, $product->cost);
		$this->assertEquals(749, $product->price);
		$this->assertEquals(5, $product->stock);
		$this->assertEquals(1, $product->low_stock);
		$this->assertEquals('new', $product->condition);
		$this->assertTrue($product->status);
		$this->assertEquals('New weight', $product->features['weight']);
		$this->assertEquals('New dimensions', $product->features['dimensions']);
		$this->assertEquals('New color', $product->features['color']);

		foreach ($product->pictures as $picture) {
			Storage::disk()->assertExists($picture->path);
		}
	}

	/** @test */
	function an_authorized_user_can_see_products_edition_form()
	{
		$product = factory(Product::class)->create();

		$this->actingAs($this->seller)
			->get(route('items.edit', ['item' => $product->id]))
			->assertSuccessful();
	}

	/** @test */
	function an_authorized_user_can_update_a_given_products()
	{
		Storage::fake('images/products');

		$product = factory(Product::class)->create();
		$category = factory('Antvel\Categories\Models\Category')->create();

		$data = [
			'category' => $category->id,
			'name' => 'Updated name',
			'description' => 'Updated description',
			'cost' => '22.49',
			'price' => '74.49',
			'stock' => 10,
			'low_stock' => 5,
			'brand' => 'Updated brand',
			'condition' => 'used',
			'status' => true,
			'features' => [
				'weight' => 'Updated weight',
				'dimensions' => 'Updated dimensions',
				'color' => 'Updated color',
			],
			'pictures' => [
				'storing' => [
					UploadedFile::fake()->image('foo.jpg'),
					UploadedFile::fake()->image('bar.jpg'),
				]
			],
		];

		$response = $this->actingAs($this->seller)
			->patch(route('items.update', ['item' => $product->id]), $data)
			->assertStatus(302);

		tap($product->fresh(), function ($product) use ($category) {
			$this->assertEquals($product->category_id, $category->id);
			$this->assertEquals('Updated name', $product->name);
			$this->assertEquals('Updated description', $product->description);
			$this->assertEquals(2249, $product->cost);
			$this->assertEquals(7449, $product->price);
			$this->assertEquals(10, $product->stock);
			$this->assertEquals(5, $product->low_stock);
			$this->assertEquals('used', $product->condition);
			$this->assertTrue($product->status);
			$this->assertEquals('Updated weight', $product->features['weight']);
			$this->assertEquals('Updated dimensions', $product->features['dimensions']);
			$this->assertEquals('Updated color', $product->features['color']);

			foreach ($product->pictures as $picture) {
				Storage::disk()->assertExists($picture->path);
			}
		});
	}
}
