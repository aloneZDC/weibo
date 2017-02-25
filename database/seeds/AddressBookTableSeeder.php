<?php

use Illuminate\Database\Seeder;
use Antvel\Components\AddressBook\Models\Address;

class AddressBookTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Address::class, 6)->create();
        factory(Address::class, 'buyer', 4)->create();
    }
}
