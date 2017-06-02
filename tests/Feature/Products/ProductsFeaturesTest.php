<?php

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

        $response = $this->get('foundation/features');

        $response
            ->assertStatus(401)
            ->assertDontSeeText('Baz');
    }

    /** @test */
    function an_authorized_is_allowed_to_manage_products_features()
    {
        $user = factory(User::class, 'admin')->create()->first();

        $this->actingAs($user);

        factory(ProductFeatures::class)->create([
            'name' => 'foo',
            'product_type' => 'item',
        ]);

        $response = $this->get('foundation/features');

        $response
            ->assertSuccessful()
            ->assertSeeText('Foo');
    }
}
