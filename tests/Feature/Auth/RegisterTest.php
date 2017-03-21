<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use Antvel\User\Mail\Registration;
use Illuminate\Support\Facades\Mail;
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
		Mail::fake();

		$data = [
            'email' => 'gocanto@gmail.com',
			'password' => bcrypt('123456'),
            'first_name' => 'Gustavo',
            'last_name' => 'Ocanto',
		];

		$response = $this->post('register', $data);

		$response->assertRedirect('login')
			->assertSessionHas('message');

		Mail::assertSent(Registration::class, function ($mail) use ($data) {

			return $mail->user->email === $data['email'] &&
				$mail->template['view'] === 'emails.accountVerification' &&
				$mail->build()->viewData['name'] == $data['first_name'] . ' ' . $data['last_name'];
        });
	}

	public function test_a_user_must_provide_a_valid_information_when_registering()
	{
		$this->post('register', []);

		$errors = $this->app->make('session')->get('errors')->all();

		$this->assertTrue(count($errors) > 0);
	}
}
