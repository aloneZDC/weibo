<?php

use App\User;
use Faker\Generator as Faker;
use Antvel\Components\AddressBook\Models\Address;

$factory->define(Address::class, function (Faker $faker)  use ($factory) {

	return [
		'default' => 0,
		'city' => $faker->city,
		'state' => $faker->state,
		'country' => $faker->country,
		'zipcode' => $faker->postcode,
		'line1' => $faker->streetAddress,
		'line2' => $faker->streetAddress,
		'phone' => $faker->e164PhoneNumber,
		'name_contact' => $faker->streetName,
		'user_id' => function () { return factory(User::class)->create()->id; },
	];
});

$factory->defineAs(Address::class, 'buyer', function (Faker $faker)  use ($factory) {

	return array_merge(
        $factory->raw(Address::class), [
            'user_id' => 4,
        ]
    );
});