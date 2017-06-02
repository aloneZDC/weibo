<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Antvel\User\Models\User;
use Tests\Browser\Pages\HomePage;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class HomeTest extends DuskTestCase
{
	use DatabaseMigrations;

	/** @test */
	function an_unauthenticated_user_can_visit_the_homepage()
	{
	    $this->browse(function ($browser) {
                $browser->visit(new HomePage)
                	->assertSee('Antvel');
        });
	}

	/** @test */
	function an_authenticated_user_can_visit_the_homepage()
	{
		$user = factory(User::class)->create([
			'nickname' => 'gocanto'
		])->first();

		$this->browse(function ($browser) use ($user) {

				$browser
					->loginAs($user)
					->visit(new HomePage)
                	->assertPathIs('/')
                	->assertSeeIn('@top-menu', $user->nickname);
        });

	}
}
