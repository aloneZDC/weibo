<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


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

        $response = $this->get('dashboard/categories');

        $response
            ->assertStatus(401)
            ->assertDontSeeText('foo');
    }

    /** @test */
    function an_authorized_is_allowed_to_manage_products_features()
    {
        $user = factory(User::class)->states('admin')->create()->first();

        $this->actingAs($user);

        $category = factory(Category::class)->create(['name' => 'foo'])->first();

        $response = $this->get('dashboard/categories');

        $response
            ->assertSuccessful()
            ->assertSeeText('Foo');
    }
}
