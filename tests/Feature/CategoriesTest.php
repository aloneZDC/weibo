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
use Antvel\Users\Models\User;
use Illuminate\Http\UploadedFile;
use Antvel\Categories\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CategoriesTest extends TestCase
{
    use DatabaseMigrations;

    protected function validaData($attributes = [])
    {
        return array_merge([
            'category_id' => null,
            'name' => 'new name',
            'description' => 'new description',
            'icon' => 'new icon',
            'image' => null,
            'status' => true,
            'type' => 'store'
        ], $attributes);
    }

    /** @test */
    function an_unauthorized_user_is_not_allowed_to_manage_products_categories()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user)
            ->get('dashboard/categories')
            ->assertStatus(401);
    }

    /** @test */
    function an_authorized_user_is_allowed_to_manage_products_categories()
    {
        $user = factory(User::class)->states('admin')->create();

        $this->actingAs($user);

        $parent = factory(Category::class)->create();
        $child = factory(Category::class)->create(['category_id' => $parent->id, 'name' => 'child']);

        $response = $this->get(route('categories.index'))
            ->assertSuccessful()
            ->assertSeeText(ucfirst($child->parent->name))
            ->assertSeeText('Child');

        $receivedList = $response->data('categories')->where('id', $child->id)->first();

        $this->assertSame($receivedList->parent->id, $parent->id);
        $this->assertSame($receivedList->id, $child->id);
    }

    /** @test */
    function an_unauthorized_user_is_not_allowed_to_create_categories()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user)->get(route('categories.index'))->assertStatus(401);
    }

    /** @test */
    function an_authorized_user_is_allowed_to_create_categories()
    {
        $user = factory(User::class)->states('admin')->create();
        $parent = factory(Category::class)->create(['name' => 'parent']);
        factory(Category::class)->create(['category_id' => $parent->id]);

        $response = $this->actingAs($user)->get(route('categories.create'));

        $response->assertSuccessful();
        $this->assertCount(1, $parents = $response->data('parents'));
        $parents->pluck('category_id')->each(function ($item) {
            $this->assertNull($item);
        });
    }

    /** @test */
    function an_unauthorized_user_is_not_allowed_to_store_categories()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user)->post(route('categories.store'))->assertStatus(401);
    }

    /** @test */
    function an_authorized_user_is_allowed_to_store_categories()
    {
        $user = factory(User::class)->states('admin')->create();

        $response = $this->actingAs($user)->post(route('categories.store'), $this->validaData([
            'pictures' => [
                'storing' => UploadedFile::fake()->image('foo.jpg'),
            ],
        ]));

        $category = Category::first();

        $response
            ->assertStatus(302)
            ->assertRedirect(route('categories.edit', ['category' => 1]));

        $this->assertNull($category->category_id);
        $this->assertEquals('new name', $category->name);
        $this->assertEquals('new description', $category->description);
        $this->assertEquals('new icon', $category->icon);
        Storage::disk()->assertExists($category->image);
        $this->assertEquals('store', $category->type);
        $this->assertTrue((bool) $category->status);
    }

    /** @test */
    function an_unauthorized_user_is_not_allowed_to_edit_categories()
    {
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create()->first();

        $this->actingAs($user)->get(route('categories.edit', $category))
            ->assertStatus(401);
    }

    /** @test */
    function an_authorized_user_is_allowed_to_edit_categories()
    {
        $user = factory(User::class)->states('admin')->create();
        $parent = factory(Category::class)->create(['name' => 'parent']);
        $child = factory(Category::class)->create(['category_id' => $parent->id]);

        $response = $this->actingAs($user)->get(route('categories.edit', $child));

        $response->assertSuccessful();
        $this->assertCount(1, $parents = $response->data('parents'));
        $this->assertEquals($parent->id, $parents->first()->id);
        $this->assertSame($response->data('category')->id, $child->id);
    }

    /** @test */
    function an_unauthorized_user_is_not_allowed_to_update_categories()
    {
        $category = factory(Category::class)->create();
        $user = factory(User::class)->create()->first();

        $this->actingAs($user)->get(route('categories.update', $category))->assertStatus(401);
    }

    /** @test */
    function an_authorized_user_is_allowed_to_update_categories()
    {
        $user = factory(User::class)->states('admin')->create();
        $category = factory(Category::class)->create();

        $response = $this->actingAs($user)->patch(route('categories.update', $category), $this->validaData([
            'pictures' => [
                'storing' => UploadedFile::fake()->image('foo.jpg'),
            ],
        ]));

        $category = $category->fresh();

        $response
            ->assertStatus(302)
            ->assertRedirect(route('categories.edit', ['category' => 1]));

        $this->assertNull($category->category_id);
        $this->assertEquals('new name', $category->name);
        $this->assertEquals('new description', $category->description);
        $this->assertEquals('new icon', $category->icon);
        Storage::disk()->assertExists($category->image);
        $this->assertEquals('store', $category->type);
        $this->assertTrue((bool) $category->status);
    }

}
