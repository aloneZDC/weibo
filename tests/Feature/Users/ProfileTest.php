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
use Antvel\User\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Storage;
use Antvel\User\Events\ProfileWasUpdated;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->user = factory(User::class)->create()->first();
    }

    protected function submit($request)
    {
        return $this->patch('user/' . $this->user->id, $request);
    }

    /** @test */
    function an_unauthorized_user_cannot_manage_profiles()
    {
        $response = $this->submit([
            'referral' => 'profile',
            'email' => 'foo@bar.com',
            'nickname' => 'foobar'
        ]);

        $response
            ->assertStatus(302)
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authorized_user_is_able_to_update_his_profile()
    {
        Event::fake();

        $this->actingAs($this->user);

        $response = $this->submit([
            'referral' => 'profile',
            'email' => 'foo@bar.com',
            'nickname' => 'foobar'
        ]);

        Event::assertDispatched(ProfileWasUpdated::class, function ($e) {
            return $e->user->id === $this->user->id
                && $e->request['email'] = 'foo@bar.com'
                && $e->request['referal'] = 'profile'
                && $e->request['nickname'] = 'foobar';
        });
    }

    /** @test */
    function the_update_request_requires_the_referral_section_to_authorize_the_petition()
    {
        $this->actingAs($this->user);

        $response = $this->submit([
            // 'referral' => 'profile',
            'email' => 'foo@bar.com',
            'nickname' => 'foobar'
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    function the_email_address_is_required()
    {
        $this->actingAs($this->user);

        $response = $this->submit([
            'referral' => 'profile',
            // 'email' => 'foo@bar.com',
            'nickname' => 'foobar'
        ]);

        $errors = $this->app->make('session')->get('errors');
        $response->assertStatus(302);
        $this->assertCount(1, $errors->get('email'));
    }

    /** @test */
    function the_email_address_has_to_be_well_formatted()
    {
        $this->actingAs($this->user);

        $response = $this->submit([
            'referral' => 'profile',
            'email' => 'foocom',
            'nickname' => 'foobar'
        ]);

        $errors = $this->app->make('session')->get('errors');
        $response->assertStatus(302);
        $this->assertCount(1, $errors->get('email'));
    }

    /** @test */
    function the_nickname_is_required()
    {
        $this->actingAs($this->user);

        $response = $this->submit([
            'referral' => 'profile',
            'email' => 'foo@bar.com',
            // 'nickname' => 'foobar'
        ]);

        $errors = $this->app->make('session')->get('errors');
        $response->assertStatus(302);
        $this->assertCount(1, $errors->get('nickname'));
    }

    /** @test */
    function an_authorized_user_can_update_his_profile_picture()
    {
        Storage::fake('images');
        $this->swapStorageFolder();

        $this->actingAs($this->user);

        $response = $this->json('PATCH', route('user.update', ['user' => $this->user]), [
            'referral' => 'upload',
            'file' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        tap($this->user->fresh()->pic_url, function ($pic_url) use ($file) {
            $this->assertEquals('images/avatars/' . $file->hashName(), $pic_url);
            Storage::disk('images')->assertExists('avatars/' . $file->hashName());
        });
    }

    /** @test */
    function an_unauthorized_user_cannot_update_his_profile_picture()
    {
        $response = $this->json('PATCH', route('user.update', ['user' => $this->user]), [
            'referral' => 'upload',
            'file' => $file = UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $this->assertEquals($this->user->pic_url, $this->user->fresh()->pic_url);
        $this->assertArrayHasKey('error', $response->decodeResponseJson());
        $response->assertStatus(401);
    }
}
