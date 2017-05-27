<?php

/*
 * This file is part of the Antvel App package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Database\Seeder;
use Antvel\User\Models\{ User, Person, Business};

class UsersTableSeeder extends Seeder
{
    /**
     * Handles the seeder command.
     *
     * @return void
     */
    public function run()
    {
        factory(Person::class)->create([
            'user_id' => factory(User::class, 'admin')->create()->first()->id
        ]);

        factory(Business::class)->create([
            'user_id' => factory(User::class, 'admin')->create([
                'nickname' => 'antvel',
                'email' => 'info@antvel.com'
            ])->first()->id
        ]);

        factory(Business::class, 1)->create([
            'user_id' => factory(User::class, 'seller', 1)->create()->first()->id
        ]);

        factory(Person::class, 1)->create([
            'user_id' => factory(User::class, 'buyer', 1)->create()->first()->id
        ]);

        factory(Person::class, 3)->create();
        factory(Business::class, 3)->create();
    }
}
