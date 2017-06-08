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
use Antvel\AddressBook\Models\Address;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddressBookTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->states('customer')->create()->first();

        $this->address = factory(Address::class, 1)->create([
            'user_id' => $this->user->id
        ])->first();
    }

    public function test_a_logged_user_can_see_his_address_book()
    {
        $this->disableExceptionHandling();

        $this->actingAs($this->user);

        $response = $this->get('addressBook');

        $response
            ->assertStatus(200)
            ->assertViewHas('addresses')
            ->assertViewHas('addresses', function ($view) {
                $data = $view->first();
                return $this->user->id == $data->user_id && $this->address->line1 == $data->line1;
        });
    }

    public function test_an_user_must_be_authenticated_to_handle_his_address_book()
    {
        $response = $this->get('addressBook');

        $response
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_an_user_can_create_an_address()
    {
        $this->actingAs($this->user);

        $response = $this->put('addressBook/store', [
            'name_contact' => 'Gustavo',
            'line1' => 'Malave Villalba',
            'country' => 'Venezuela',
            'phone' => '0000000000',
            'state' => 'Carabobo',
            'city' => 'Guacara',
            'zipcode' => '2001',
            'line2' => '',
        ]);

        $response->assertJson([
            'message' => trans('address.success_save'),
            'redirectTo' => '/addressBook',
            'callback' => '/addressBook',
            'success' => true,
        ]);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $this->user->id,
            'name_contact' => 'Gustavo',
            'zipcode' => '2001',
        ]);
    }

    public function test_the_address_information_has_to_pass_validation_rules()
    {
        $this->actingAs($this->user);

        $response = $this->put('addressBook/store', []);

        $response->assertStatus(302);
    }

    public function test_an_address_can_be_deleted()
    {
        $this->actingAs($this->user);

        $response = $this->post('addressBook/delete', ['id' => $this->address->id]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('addresses', [
            'id' => $this->address->id,
            ['deleted_at', '!=', null]
        ]);
    }

    public function test_an_address_can_be_marked_as_default()
    {
        $this->actingAs($this->user);

        $response = $this->post('addressBook/default', ['id' => $this->address->id]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('addresses', [
            'id' => $this->address->id,
            'default' => 1
        ]);
    }
}
