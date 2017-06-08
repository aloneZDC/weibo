<?php

/*
 * This file is part of the Antvel App package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Antvel\User\Models\User;
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
        factory(Address::class, 3)->create([
            'user_id' => User::where('role', 'like', 'customer')->take(1)->first()->id
        ]);
    }
}
