<?php

/*
_* This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Integration\AddressBook;

use App\User as UserApp;
use App\Tests\AbstractTestCase;
use Antvel\Components\Customer\Models\User;

class AddressBookControllerTest extends AbstractTestCase
{
	/**
	 * The tester user.
	 *
	 * @var null
	 */
	protected $buyer = null;

	public function setUp()
	{
		parent::setUp();

		$this->buyer = User::where('id', 4)->first();

		// dd($this->buyer);
	}

	public function test_a_logged_user_can_see_his_address_book()
	{
		// dd($this->buyer->toArray());
		// dd($this->buyer->role, $this->buyer->profile);

		$this->actingAs($this->buyer);

		// dd($this->app['auth']->user()->toArray());


		$response = $this->call('GET', 'user/address');

		// dd($response->content());
		// dd($response->isRedirect());
		// dd(get_class_methods($this->buyer));

		$this->assertResponseOk();
		// $this->assertViewHas('addresses');
	}

}