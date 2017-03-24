<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Antvel\User\Models\Person;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use App\Notifications\Auth\ResetPasswordNotification;

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
		Notification::fake();

		$person = factory(Person::class)->create()->first();

		$response = $this->post('password/email', [
			'email' => $person->user->email
		]);

		$response->assertSessionHas('status');

		Notification::assertSentTo(
            [$person->user], ResetPasswordNotification::class
        );
	}
}
