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
use Antvel\User\Models\User;
use Antvel\Product\Models\ProductFeatures;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProductsFeaturesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_unauthorized_is_not_allowed_to_manage_products_features()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user);

        factory(ProductFeatures::class)->create([
            'name' => 'baz',
            'product_type' => 'item',
        ]);

        $response = $this->get('dashboard/features');

        $response
            ->assertStatus(401)
            ->assertDontSeeText('Baz');
    }

    /** @test */
    function an_authorized_is_allowed_to_manage_products_features()
    {
        $user = factory(User::class)->states('admin')->create()->first();

        $this->actingAs($user);

        factory(ProductFeatures::class)->create([
            'name' => 'foo',
            'product_type' => 'item',
        ]);

        $response = $this->get('dashboard/features');

        $response
            ->assertSuccessful()
            ->assertSeeText('Foo');
    }
}
