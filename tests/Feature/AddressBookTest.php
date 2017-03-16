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
	use DatabaseTransactions;

    public function test_a_logged_user_can_see_his_address_book()
    {
    	$user = $this->user(3);

    	$address = factory(Address::class, 1)->create([
    		'user_id' => $user->id
    	])->first();

        $this->actingAs($user);

        $response = $this->call('GET', 'user/address');

        $response
        	->assertStatus(200)
        	->assertViewHas('addresses')
        	->assertViewHas('addresses', function($view) use ($user, $address) {
        		$data = $view->first();
        		return $user->id === $data->user_id && $address->line1 === $data->line1;
        	});
    }

    public function test_an_user_must_be_logged_in_to_handle_his_address_book()
    {
    	$response = $this->call('GET', 'user/address');

    	$response
    		->assertStatus(302)
    		->assertRedirect('/login');
    }

    public function test_an_user_can_create_an_address()
    {
    	$user = $this->user(3);
        $this->actingAs($user);

    	$response = $this->put('user/address/store', [
            'line1' => 'Malave Villalba',
            'name_contact' => 'Gustavo',
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

    	$address = Address::latest()->first();

    	$this->assertEquals($address->name_contact, 'Gustavo');
    	$this->assertEquals($address->city, 'Guacara');
    	$this->assertEquals($address->default, 1);
    }

    public function test_the_address_information_has_to_pass_validation_rules()
    {
    	$user = $this->user(3);
        $this->actingAs($user);

    	$response = $this->put('user/address/store', []);

    	$response->assertStatus(302);
    }

    public function test_an_address_can_be_deleted()
    {
    	$user = $this->user(3);
    	$this->actingAs($user);

    	$address = factory(Address::class, 1)->create([
    		'user_id' => $user->id
    	])->first();

    	$response = $this->post('user/address/delete', ['id' => $address->id]);

    	$response->assertStatus(200);
    }

    public function test_an_address_can_be_marked_as_default()
    {
    	$user = $this->user(3);
    	$this->actingAs($user);

    	$address = Address::inRandomOrder()->first();

    	$response = $this->post('user/address/default', ['id' => $address->id]);

    	$response->assertStatus(200);
    }
}
