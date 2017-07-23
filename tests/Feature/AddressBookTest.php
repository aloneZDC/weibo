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
    }

    /** @test */
    function signed_users_can_see_their_address_book()
    {
        $this->actingAs($this->user);
        $address = factory(Address::class, 1)->create(['user_id' => $this->user->id])->first();

        $response = $this->get('addressBook')
            ->assertStatus(200)
            ->assertViewHas('addresses')
            ->assertViewHas('addresses', function ($view) use ($address) {
                $data = $view->first();
                return $this->user->id == $data->user_id && $address->line1 == $data->line1;
        });
    }

    /** @test */
    function unsigned_users_cannot_see_their_address_book()
    {
        $response = $this->get('addressBook');

        $response
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    function signed_users_can_create_an_address()
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

    /** @test */
    function unsigned_users_cannot_create_an_address()
    {
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

        $response->assertStatus(302)->assertRedirect('/login');

        $this->assertCount(0, Address::get());
    }

    /** @test */
    public function a_valid_information_has_to_be_provided()
    {
        $this->actingAs($this->user);

        $response = $this->put('addressBook/store', []);

        $response->assertStatus(302);
        $this->assertCount(0, Address::get());
    }

    /** @test */
    public function an_address_can_be_deleted()
    {
        $this->actingAs($this->user);
        $address = factory(Address::class, 1)->create(['user_id' => $this->user->id])->first();

        $this->post('addressBook/delete', ['id' => $address->id])->assertStatus(200);
    }

     /** @test */
    public function an_address_can_be_marked_as_default()
    {
        $this->actingAs($this->user);
        $address_one = factory(Address::class)->create(['user_id' => $this->user->id, 'default' => false])->first();
        $address_two = factory(Address::class)->create(['user_id' => $this->user->id, 'default' => false])->first();

        $this->post('addressBook/default', ['id' => $address_one->id])->assertStatus(200);

        tap($this->user->fresh()->addresses, function ($addresses) {
            $this->assertTrue($addresses->first()->default);
            $this->assertFalse($addresses->last()->default);
        });
    }

    /** @test */
    function it_can_see_the_edition_page()
    {
        $this->actingAs($this->user);
        $address = factory(Address::class)->create(['user_id' => $this->user->id])->first();

        $this->get(route('addressBook.edit', ['id' => $address->id]))->assertStatus(200);
    }

    /** @test */
    function it_can_update_a_given_address()
    {
        $this->disableExceptionHandling();

        $this->actingAs($this->user);
        $address = factory(Address::class)->create(['user_id' => $this->user->id])->first();

        $this->put(route('addressBook.update', ['id' => $address->id]), [
            'name_contact' => 'Gustavo Ocanto',
            'line1' => 'Malave Villalba',
            'country' => 'Venezuela',
            'phone' => '0414-428.42.30',
            'state' => 'Carabobo',
            'city' => 'Guacara',
            'zipcode' => '2001'
        ])->assertSuccessful();

        tap($address->fresh()->first(), function ($address) {
            $this->assertEquals('Gustavo Ocanto', $address->name_contact);
            $this->assertEquals('0414-428.42.30', $address->phone);
            $this->assertEquals('Malave Villalba', $address->line1);
            $this->assertEquals('Carabobo', $address->state);
            $this->assertEquals('Guacara', $address->city);
            $this->assertEquals('Venezuela', $address->country);
            $this->assertEquals('2001', $address->zipcode);
        });
    }
}
