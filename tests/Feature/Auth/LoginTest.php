<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
	use DatabaseMigrations;

	public function test_a_login_page_can_be_visited()
	{
		$this->get('/login')
			->assertStatus(200)
			->assertSee('login');
	}

	public function test_a_user_can_authenticate()
	{
		$user = factory(User::class)->create()->first();

		$response = $this->post('login', [
			'email' => $user->email,
			'password' => '123456'
		]);

		$response->assertRedirect('/');

		$this->assertEquals(
			$user, $this->app->make('auth')->user()
		);
	}

	public function test_a_user_must_be_registered_to_log_into_the_app()
	{
		$response = $this->post('login', [
			'email' => 'foo@bar.com',
			'password' => '123456'
		]);

		$response->assertRedirect('/login');

		$this->assertNull($this->app->make('auth')->user());
	}

	public function test_the_credentials_given_have_to_be_well_formatted()
	{
		$response = $this->post('login', [
			'email' => 'foo',
			'password' => ''
		]);

		$response
			->assertSessionHasErrors([
				'email', 'password'
			]);
	}

}
