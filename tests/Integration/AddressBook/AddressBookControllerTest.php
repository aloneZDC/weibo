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

use App\User;
use App\Tests\AbstractTestCase;

class AddressBookControllerTest extends AbstractTestCase
{
	/**
	 * The tester user.
	 *
	 * @var null
	 */
	protected $user = null;

	public function setUp()
	{
		parent::setUp();

		$this->user = User::where('id', 4)->first();
	}

	public function test_a_logged_user_can_see_his_address_book()
	{
		$this->actingAs($this->user);
		$response = $this->call('GET', 'user/address');

		$this->assertResponseOk();
		$this->assertViewHas('addresses');
	}

}