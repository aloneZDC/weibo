<?php

namespace Tests\Feature;

use Tests\TestCase;
use Antvel\User\Models\User;
use Antvel\Categories\Models\Category;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoriesTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_unauthorized_is_not_allowed_to_manage_products_categories()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user);

        $category = factory(Category::class)->create(['name' => 'foo'])->first();

        $response = $this->get('foundation/categories');

        $response
            ->assertStatus(401)
            ->assertDontSeeText('foo');
    }

    /** @test */
    function an_authorized_is_allowed_to_manage_products_features()
    {
        $user = factory(User::class, 'admin')->create()->first();

        $this->actingAs($user);

        $category = factory(Category::class)->create(['name' => 'foo'])->first();

        $response = $this->get('foundation/categories');

        $response
            ->assertSuccessful()
            ->assertSeeText('Foo');
    }
}
