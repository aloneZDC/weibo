<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tests\Users\Feature;

use Tests\TestCase;
use Antvel\Users\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AccountSecurityTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_authorized_user_is_able_to_disable_his_account()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user);

        $response = $this->patch(route('user.action', ['action' => 'disable']));

        $payload = $response->decodeResponseJson();

        $response->assertStatus(200);
        $this->assertTrue($payload['success']);
    }

    /** @test */
    function an_authorized_user_is_able_to_enable_his_account()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user);

        $response = $this->patch(route('user.action', ['action' => 'enable']));

        $payload = $response->decodeResponseJson();

        $response->assertStatus(200);
        $this->assertTrue($payload['success']);
    }

    /** @test */
    function an_authorized_user_has_to_provide_a_valid_endpoint_to_disable_his_account()
    {
        $user = factory(User::class)->create()->first();

        $this->actingAs($user);

        $response = $this->patch(route('user.action', ['action' => 'foo']));

        $payload = $response->decodeResponseJson();

        $response->assertStatus(404);
        $this->assertFalse($payload['success']);
    }

    /** @test */
    function an_unauthorized_user_is_not_allowed_to_manage_his_account_security_options()
    {
        $user = factory(User::class)->create()->first();

        $response = $response = $this->patch(route('user.action', ['action' => 'enable']));

        $response
        	->assertStatus(302)
        	->assertRedirect('/login');
    }
}
