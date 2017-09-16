<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Tests\Feature\Auth;

use Tests\TestCase;
use Antvel\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function the_login_page_can_be_visited()
	{
		$this->get('/login')
			->assertStatus(200)
			->assertSee('login');
	}

	/** @test */
	public function an_existing_user_can_be_authenticated()
	{
		$user = factory(User::class)->create(['email' => 'foo@bar.com', 'verified' => true]);

		$response = $this->post('login', ['email' => 'foo@bar.com', 'password' => '123456']);

		tap($this->app->make('auth')->user(), function ($auth) use ($user) {
			$this->assertEquals($auth->nickname, $user->nickname);
			$this->assertEquals($auth->email, $user->email);
		});
	}

	/** @test */
	public function an_unregistered_user_cannot_login_into_the_application()
	{
		$this
			->post('login', ['email' => 'foo@bar.com', 'password' => '123456'])
			->assertStatus(302);

		$this->assertNull($this->app->make('auth')->user());
	}

	/** @test */
	function the_user_email_is_required()
	{
		$this
			->post('login', ['email' => '', 'password' => '123456'])
			->assertSessionHasErrors('email');
	}

	/** @test */
	function the_user_email_has_to_be_a_valid_email_format()
	{
		$this
			->post('login', ['email' => 'foo', 'password' => '123456'])
			->assertSessionHasErrors('email');
	}

	/** @test */
	function the_user_password_is_required()
	{
		$this
			->post('login', ['email' => 'foo@bar.com', 'password' => ''])
			->assertSessionHasErrors('password');
	}
}
