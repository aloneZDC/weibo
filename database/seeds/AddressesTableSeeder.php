<?php

/*
 * This file is part of the Antvel Shop package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\User as User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Antvel\AddressBook\Models\Address;

class AddressesTableSeeder extends Seeder
{
    /**
     * Handles the seeder.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 10; $i++) {
            Address::create(
                $this->faker($i)
            );
        }
    }

    /**
     * Return a fake address.
     * @param  int $pos
     * @return array
     */
    protected function faker(int $pos) : array
    {
        $faker = Faker::create();
        $user_id = $pos <= 2 ? 4 :  $this->user()->id;

        return [
            'default' => 0,
            'user_id' => $user_id,
            'city' => $faker->city,
            'state' => $faker->state,
            'country' => $faker->country,
            'zipcode' => $faker->postcode,
            'line1' => $faker->streetAddress,
            'line2' => $faker->streetAddress,
            'phone' => $faker->e164PhoneNumber,
            'name_contact' => $faker->streetName,
        ];
    }

    /**
     * Return a random user.
     *
     * @return User
     */
    protected function user() : User
    {
        return User::select('id')->inRandomOrder()->first();
    }
}
