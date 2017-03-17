<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Antvel\AddressBook\Models\Address;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AddressBookTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * The given user.
     *
     * @var User
     */
    protected $user = null;

    /**
     * The given address.
     *
     * @var Address
     */
    protected $address = null;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create()->first();

        $this->address = factory(Address::class, 1)->create([
            'user_id' => $this->user->id
        ])->first();
    }

    public function test_a_logged_user_can_see_his_address_book()
    {
        $this->actingAs($this->user);

        $response = $this->call('GET', 'user/address');

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
        $response = $this->get('user/address');

        $response
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    public function test_an_user_can_create_an_address()
    {
        $this->actingAs($this->user);

        $response = $this->put('user/address/store', [
            'name_contact' => 'Gustavo',
            'line1' => 'Malave Villalba',
            'country' => 'Venezuela',
            'phone' => '0000000000',
            'state' => 'Carabobo',
            'city' => 'Guacara',
            'zipcode' => '2001',
            'line2' => '',
        ]);

        $response->assertExactJson([
            'message' => trans('address.success_save'),
            'redirectTo' => '/user/address',
            'callback' => '/user/address',
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

        $response = $this->put('user/address/store', []);

        $response->assertStatus(302);
    }

    public function test_an_address_can_be_deleted()
    {
        $this->actingAs($this->user);

        $response = $this->post('user/address/delete', ['id' => $this->address->id]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('addresses', [
            'id' => $this->address->id,
            ['deleted_at', '!=', null]
        ]);
    }

    public function test_an_address_can_be_marked_as_default()
    {
        $this->actingAs($this->user);

        $response = $this->post('user/address/default', ['id' => $this->address->id]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('addresses', [
            'id' => $this->address->id,
            'default' => 1
        ]);
    }
}
