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
use Antvel\User\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ResetPasswordTest extends TestCase
{
	use DatabaseMigrations;

	public function test_a_reset_password_page_can_be_visited()
	{
		$this->get('/password/reset')
			->assertStatus(200)
			->assertSee('email');
	}

	public function test_a_user_can_request_to_reset_his_password()
	{
		$this->disableExceptionHandling();

		$user = factory(User::class)->create()->first();

		$response = $this->post('password/email', [
			'email' => $user->email
		]);

		$this->assertTrue(app('session.store')->has('status'));
	}
}
