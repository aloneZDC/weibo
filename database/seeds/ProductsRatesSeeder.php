<?php

/**
 * Antvel - Seeder
 * Products Rates Table.
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\User;
use App\Order;
use App\UserPoints;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Antvel\Product\Models\Product;
use Antvel\AddressBook\Models\Address;
use Antvel\Categories\Models\Category;

class ProductsRatesSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $user = User::select('id')->where('id', 4)->first();
        $catforseed = Category::where('type', 'store')->first();

        for ($j = 0; $j < 2; $j++) {
            $userPoints = UserPoints::create([
                'user_id' => $user->id,
                'action_type_id' => 6,
                'source_id' => 1,
                'points' => 100,
            ]);
        }

        $userAddress = factory(Address::class)->create([
            'user_id' => $user->id,
            'default' => 1,
        ]);

        $seededProduct = factory(Product::class)->create([
            'category_id'  => $catforseed->id,
            'user_id' => '3'
        ])->first();



        for ($j = 0; $j < 5; $j++) {
            $order = Order::create([
                'user_id'     => $user->id,
                'seller_id'   => '3',
                'address_id'  => $userAddress->id,
                'status'      => 'closed',
                'type'        => 'order',
                'description' => '',
                'seller_id'   => 3,
                'end_date'    => $faker->dateTime(),
            ]);

            $order->details()->create([
                'product_id'    => $seededProduct->id,
                'price'         => $seededProduct->price,
                'quantity'      => '1',
                'delivery_date' => $faker->dateTime(),
                'rate'          => $faker->numberBetween(1, 5),
                'rate_comment'  => $faker->text(90),
            ]);
        }

        $seededProduct2 = factory(Product::class)->create([
            'category_id'  => $catforseed->id,
            'user_id'      => '3',
        ])->first();

        $seededProduct3 = factory(Product::class)->create([
            'category_id'  => $catforseed->id,
            'user_id'      => '3'
        ])->first();



        // Creates closed orders for rates and mails
        for ($j = 0; $j < 5; $j++) {
            $order = Order::create([
                'user_id'     => $user->id,
                'seller_id'   => '3',
                'address_id'  => $userAddress->id,
                'status'      => 'closed',
                'type'        => 'order',
                'description' => '',
                'seller_id'   => 3,
                'end_date'    => $faker->dateTime(),
            ]);

            $order->details()->create([
                'product_id'    => $seededProduct->id,
                'price'         => $seededProduct->price,
                'quantity'      => '1',
                'delivery_date' => $faker->dateTime(),
            ]);
        }

        // Create an open order to test notices
        $order = Order::create([
            'user_id'     => $user->id,
            'seller_id'   => '3',
            'status'      => 'open',
            'type'        => 'order',
            'description' => '',
            'seller_id'   => 3,
            'address_id'  => $userAddress->id,
        ]);

        $order->details()->create([
            'product_id' => $seededProduct->id,
            'price'      => $seededProduct->price,
            'quantity'   => '3',
        ]);
    }
}
