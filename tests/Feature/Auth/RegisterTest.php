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
use Antvel\User\Mail\Registration;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RegisterTest extends TestCase
{
	use DatabaseMigrations;

    public function test_a_register_page_can_be_visited()
	{
		$this->get('/register')
			->assertStatus(200)
			->assertSee('register');
	}

	public function test_a_user_is_able_to_sign_up()
	{
		Notification::fake();

		$data = [
            'email' => 'gocanto@gmail.com',
			'password' => bcrypt('123456'),
            'first_name' => 'Gustavo',
            'last_name' => 'Ocanto',
		];

		$response = $this->post('register', $data);

		$response->assertRedirect('login')
			->assertSessionHas('message');

		$user = app()->make(\Antvel\User\UsersRepository::class)->find([
			'email' => $data['email']
		]);

		Notification::assertSentTo(
            [$user], \Antvel\User\Notifications\Registration::class
        );
	}

	public function test_a_user_must_provide_a_valid_information_when_registering()
	{
		$response = $this->post('register', []);

		$errors = $this->app->make('session')->get('errors')->all();

		$this->assertTrue(count($errors) > 0);
	}
}
