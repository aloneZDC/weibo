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

use App\User;
use Tests\TestCase;
use Antvel\Users\Policies\Roles;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Antvel\Users\Notifications\RegistrationNotification;

class RegisterTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function the_signup_page_can_be_visited()
	{
		$this->get(route('register'))->assertStatus(200)->assertSee('register');
	}

	/** @test */
	public function a_new_user_can_sign_up()
	{
		Notification::fake();

		$this->post('register', ['email' => 'foo@bar.com','password' => bcrypt('123456'),'first_name' => 'foo','last_name' => 'bar'])
			->assertRedirect('login')
			->assertSessionHas('message');

		$this->assertFalse($this->app->make('auth')->check());

		tap($user = User::latest()->first(), function ($user) {
			$this->assertEquals('foo@bar.com', $user->nickname);
			$this->assertEquals(Roles::default(), $user->role);
			$this->assertEquals('foo@bar.com', $user->email);
			$this->assertNotNull($user->confirmation_token);
			$this->assertEquals('foo', $user->first_name);
			$this->assertEquals('bar', $user->last_name);
			$this->assertFalse($user->verified);
		});

		Notification::assertSentTo($user, RegistrationNotification::class);
	}

	/** @test */
	function an_user_is_able_to_confirm_his_account()
	{
		Notification::fake();

		$this->post('register', ['email' => 'foo@bar.com','password' => bcrypt('123456'),'first_name' => 'foo','last_name' => 'bar']);

		$user = User::latest()->first();

		$response = $this->get(route('register.confirm', [
			'token' => $user->confirmation_token,
			'email' => $user->email,
		]));

		$this->assertTrue($user->fresh()->verified);

		tap($this->app->make('auth'), function ($auth) use ($user) {
			$this->assertTrue($auth->check());
			$this->assertTrue($auth->user()->is($user));
		});
	}

	/** @test */
	function it_throws_404_if_the_given_data_did_not_match_any_users()
	{
		Notification::fake();

		$this->post('register', ['email' => 'foo@bar.com','password' => bcrypt('123456'),'first_name' => 'foo','last_name' => 'bar']);

		$user = User::latest()->first();

		$response = $this->get(route('register.confirm', [
			'token' => 'foo',
			'email' => $user->email,
		]));

		$response->assertStatus(404);
		$this->assertFalse($user->fresh()->verified);
		$this->assertFalse($this->app->make('auth')->check());
	}
}
