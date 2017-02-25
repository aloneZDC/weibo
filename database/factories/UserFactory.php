<?php

use App\User;
use Faker\Generator as Faker;
use Antvel\Components\Customer\Models\Person;
use Antvel\Components\Customer\Models\Business;

$factory->define(User::class, function (Faker $faker) {
    return [
        'role' => 'person',
        'password' => bcrypt('123456'),
        'nickname' => $faker->userName,
        'facebook' => $faker->userName,
        'twitter' => '@'.$faker->userName,
        'email'  => $faker->unique()->email,
        'pic_url' => '/img/pt-default/'.$faker->numberBetween(1, 20).'.jpg',
        'preferences' => '{"product_viewed":[],"product_purchased":[],"product_shared":[],"product_categories":[],"my_searches":[]}',
    ];
});

$factory->defineAs(User::class, 'root', function (Faker $faker) use ($factory)
{
    return array_merge(
        $factory->raw(User::class), [
            'role' => 'admin',
            'type' => 'trusted',
            'nickname' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
        ]
    );
});

$factory->defineAs(User::class, 'admin', function (Faker $faker) use ($factory)
{
    return array_merge(
        $factory->raw(User::class), [
            'role' => 'admin',
            'type' => 'trusted',
            'nickname' => 'dev',
            'email' => 'dev@antvel.com',
            'password' => bcrypt('123456'),
        ]
    );
});

$factory->defineAs(User::class, 'seller', function (Faker $faker) use ($factory)
{
    return array_merge(
        $factory->raw(User::class), [
            'role' => 'business',
            'type' => 'trusted',
            'nickname' => 'antvelseller',
            'email' => 'seller@antvel.com',
            'password' => bcrypt('123456'),
        ]
    );
});

$factory->defineAs(User::class, 'buyer', function (Faker $faker) use ($factory)
{
    return array_merge(
        $factory->raw(User::class), [
            'role' => 'person',
            'type' => 'trusted',
            'nickname' => 'antvelbuyer',
            'email' => 'buyer@antvel.com',
            'password' => bcrypt('123456'),
        ]
    );
});

$factory->define(Person::class, function (Faker $faker)  use ($factory) {
    return [
        'last_name' => $faker->lastName,
        'first_name' => $faker->firstName,
        'home_phone' => $faker->e164PhoneNumber,
        'gender' => $faker->randomElement(['male', 'female']),
        'birthday' => $faker->dateTimeBetween('-40 years', '-16 years'),
        'user_id' => function () { return factory(User::class)->create()->id; },
    ];
});

$factory->define(Business::class, function (Faker $faker)  use ($factory) {
    return [
        'creation_date' => $faker->date(),
        'business_name' => $faker->company,
        'local_phone'   => $faker->e164PhoneNumber,
        'user_id' => function () { return factory(User::class)->create(['role' => 'business'])->id; },
    ];
});




