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

class ResetPasswordTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	public function the_reset_password_page_can_be_visited()
	{
		$this->get(route('password.request'))
			->assertStatus(200)
			->assertSee('email');
	}

	/** @test */
	function the_send_reset_link_form_can_be_visited()
	{
	 	$this->get(route('password.request'))
	 		->assertSuccessful()
	 		->assertSee('email');
	}

	/** @test */
	function an_authorized_user_with_a_valid_token_is_able_to_reset_his_password()
	{
		$user = factory(User::class)->create();

	    $response = $this->post('password/reset', [
	    	'token' => $this->app->make('auth.password')->createToken($user),
	    	'password_confirmation' => '654321',
	    	'email' => $user->email,
	    	'password' => '654321',
	    ]);

	    $response
	    	->assertStatus(302)
	    	->assertRedirect(route('home'));

	    $this->assertTrue(
	    	$this->app->make('hash')->check('654321', $user->fresh()->password)
	    );
	}
}
