<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Tests\Browser;

use Tests\DuskTestCase;
use Antvel\Users\Models\User;
use Tests\Browser\Pages\DashboardPage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class DashboardTest extends DuskTestCase
{
	use DatabaseMigrations;

	/** @test */
	function an_unauthenticated_user_cannot_visit_the_dashboard()
	{
	    $this->browse(function ($browser) {
                $browser->visit(new DashboardPage)
                	->assertPathIs('/login');
        });
	}

	/** @test */
	function an_authenticated_user_can_visit_the_dashboard()
	{
		$user = factory(User::class)->states('admin')->create()->first();

		$this->browse(function ($browser) use ($user) {

				$browser
					->loginAs($user)
					->visit(new DashboardPage)
                	->assertPathIs('/dashboard')
                	->assertSeeIn('.navbar-brand', 'Antvel');
        });
	}
}
