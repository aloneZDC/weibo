<?php

/*
 * This file is part of the Antvel App package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Antvel\Users\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Handles the seeder command.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->states('admin')->create();

        factory(User::class)->states('seller')->create();

        factory(User::class)->states('customer')->create();

        factory(User::class, 7)->create();
    }
}
