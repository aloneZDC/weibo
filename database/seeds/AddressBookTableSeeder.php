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
use Antvel\AddressBook\Models\Address;

class AddressBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = app()->make(\Antvel\User\UsersRepository::class)->find([
            'nickname' => 'buyer'
        ]);

        factory(Address::class, 6)->create([
            'user_id' => $user->id
        ]);
    }
}
