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
use Antvel\AddressBook\Models\Address;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AddressBookTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->states('customer')->create();
    }

    protected function validData($attributes = [])
    {
        return array_merge($attributes, [
            'name_contact' => 'Gustavo',
            'line1' => 'Malave Villalba',
            'country' => 'Venezuela',
            'phone' => '0000000000',
            'state' => 'Carabobo',
            'city' => 'Guacara',
            'zipcode' => '2001',
            'line2' => '',
        ]);
    }

    /** @test */
    public function addresses_must_be_created_with_a_valid_information()
    {
        $this->actingAs($this->user)
            ->post(route('addressBook.store'))
            ->assertStatus(302);

        $this->assertCount(0, Address::get());
    }

    /** @test */
    function signed_users_can_see_their_address_book()
    {
        $this->actingAs($this->user);
        $address = factory(Address::class)->create(['user_id' => $this->user->id]);

        $response = $this->get(route('addressBook.index'))
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
        $this->get(route('addressBook.index'))->assertStatus(302)->assertRedirect(
            route('login')
        );
    }

    /** @test */
    function signed_users_can_create_addresses()
    {
        $this->actingAs($this->user)
            ->get(route('addressBook.create'))
            ->assertSuccessful();
    }

    /** @test */
    function unsigned_users_cannot_create_addresses()
    {
        $this->get(route('addressBook.create'))
            ->assertStatus(302)
            ->assertRedirect(route('login'));
    }

    /** @test */
    function signed_users_can_store_an_address()
    {
        $this->actingAs($this->user)
            ->post(route('addressBook.store'), $this->validData())
            ->assertJson([
                'message' => trans('address.success_save'),
                'redirectTo' => route('addressBook.index'),
                'callback' => route('addressBook.index'),
                'success' => true,
            ]);

        tap(Address::first(), function ($address) {
            $this->assertEquals($this->user->id, $address->user_id);
            $this->assertEquals('Gustavo', $address->name_contact);
            $this->assertEquals('Malave Villalba', $address->line1);
            $this->assertEquals('Venezuela', $address->country);
            $this->assertEquals('0000000000', $address->phone);
            $this->assertEquals('Carabobo', $address->state);
            $this->assertEquals('Guacara', $address->city);
            $this->assertEquals('2001', $address->zipcode);
            $this->assertEquals('', $address->line2);
        });    }

    /** @test */
    function unsigned_users_cannot_store_an_address()
    {
        $this->post(route('addressBook.store'), $this->validData())
            ->assertStatus(302)->assertRedirect(
                route('login')
            );

        $this->assertCount(0, Address::get());
    }

    /** @test */
    function signed_users_can_edit_theirs_addresses()
    {
        $address = factory(Address::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)
            ->get(route('addressBook.edit', ['addressBook' => $address->id]))
            ->assertStatus(200);
    }

    /** @test */
    function signed_users_cannot_edit_other_users_addresses()
    {
        $addressA = factory(Address::class)->create(['user_id' => $this->user->id]);

        $userB = factory(User::class)->create();
        $addressB = factory(Address::class)->create(['user_id' => $userB->id]);

        $this->actingAs($this->user)
            ->get(route('addressBook.edit', ['addressBook' => $addressB->id]))
            ->assertStatus(404)
            ->assertDontSee($addressB->name_contact);
    }

    /** @test */
    function signed_users_can_update_theirs_addresses()
    {
        $address = factory(Address::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user)->put(route('addressBook.update', ['addressBook' => $address->id]), [
            'name_contact' => 'New contact',
            'line1' => 'New line1',
            'country' => 'New country',
            'phone' => '1236780987',
            'state' => 'New state',
            'city' => 'New city',
            'zipcode' => '00000',
            'line2' => 'New line2',
        ])->assertSuccessful();

        tap($address->fresh(), function ($address) {
            $this->assertEquals('New contact', $address->name_contact);
            $this->assertEquals('New line1', $address->line1);
            $this->assertEquals('New country', $address->country);
            $this->assertEquals('1236780987', $address->phone);
            $this->assertEquals('New state', $address->state);
            $this->assertEquals('New city', $address->city);
            $this->assertEquals('00000', $address->zipcode);
            $this->assertEquals('New line2', $address->line2);
        });
    }

    /** @test */
    function signed_users_cannot_update_other_users_addresses()
    {
        $addressA = factory(Address::class)->create(['user_id' => $this->user->id]);

        $userB = factory(User::class)->create();
        $addressB = factory(Address::class)->create([
            'user_id' => $userB->id,
            'name_contact' => 'Old contact',
            'line1' => 'Old line1',
            'country' => 'Old country',
            'phone' => '9999999999',
            'state' => 'Old state',
            'city' => 'Old city',
            'zipcode' => '99999',
            'line2' => 'Old line2',
        ]);

        $this->actingAs($this->user)->put(route('addressBook.update', ['addressBook' => $addressB->id]), $this->validData())->assertStatus(404);

        tap($addressB->fresh(), function ($address) {
            $this->assertEquals('Old contact', $address->name_contact);
            $this->assertEquals('Old line1', $address->line1);
            $this->assertEquals('Old country', $address->country);
            $this->assertEquals('9999999999', $address->phone);
            $this->assertEquals('Old state', $address->state);
            $this->assertEquals('Old city', $address->city);
            $this->assertEquals('99999', $address->zipcode);
            $this->assertEquals('Old line2', $address->line2);
        });
    }

    /** @test */
    function signed_users_can_destroy_theirs_addresses()
    {
        $address = factory(Address::class)->create(['user_id' => $this->user->id])->first();

        $this->actingAs($this->user)
            ->delete(route('addressBook.destroy', ['addressBook' => $address->id]))
            ->assertSuccessful();

        $this->assertFalse(Address::where('id', $address->id)->exists());
    }

    /** @test */
    function signed_users_cannot_destroy_other_users_addresses()
    {
        $addressA = factory(Address::class)->create(['user_id' => $this->user->id]);

        $userB = factory(User::class)->create();
        $addressB = factory(Address::class)->create(['user_id' => $userB->id]);

        $this->actingAs($this->user)
            ->delete(route('addressBook.destroy', ['addressBook' => $addressB->id]))
            ->assertStatus(404);

        $this->assertTrue(Address::where('id', $addressB->id)->exists());
    }

    /** @test */
    function signed_users_can_have_a_default_address_in_their_list()
    {
        $addressA = factory(Address::class)->create(['user_id' => $this->user->id, 'default' => 0]);
        $addressB = factory(Address::class)->create(['user_id' => $this->user->id, 'default' => 0]);

        $this->actingAs($this->user)
            ->post(route('addressBook.default'), ['id' => $addressA->id])
            ->assertSuccessful();

        $this->assertTrue((bool) $addressA->fresh()->default);
        $this->assertFalse((bool) $addressB->fresh()->default);
    }

    /** @test */
    function signed_users_cannot_assign_other_users_addresses_to_default()
    {
        $addressA = factory(Address::class)->create(['user_id' => $this->user->id, 'default' => 0]);

        $userB = factory(User::class)->create();
        $addressB = factory(Address::class)->create(['user_id' => $userB->id, 'default' => 0]);

        $this->actingAs($userB)
            ->post(route('addressBook.default'), ['id' => $addressA->id])
            ->assertStatus(404);

        $this->assertFalse((bool) $addressB->fresh()->default);
    }
}
