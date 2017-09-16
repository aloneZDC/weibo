<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Tests\Companies;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AboutTest extends TestCase
{
	use DatabaseMigrations;

	/** @test */
	function the_about_page_can_be_visited()
	{
		$response = $this->get(route('about'))->assertSuccessful();

		$this->assertEquals('about', $response->data('tab'));
	}

	/** @test */
	function the_terms_page_can_be_visited()
	{
		$response = $this->get(route('about', ['section' => 'terms']))->assertSuccessful();
		$this->assertEquals('terms', $response->data('tab'));
	}

	/** @test */
	function the_refunds_page_can_be_visited()
	{
		$response = $this->get(route('about', ['section' => 'refunds']))->assertSuccessful();
		$this->assertEquals('refunds', $response->data('tab'));
	}
}
