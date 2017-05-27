<?php

/*
 * This file is part of the Antvel App package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Antvel\Product\Models\Product;
use App\ProductOffer as ProductOffer;
use Antvel\Categories\Models\Category;

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        $product = factory(Product::class, 150)->create([
            'category_id'  => Category::inRandomOrder()->first()->id,
            'user_id' => 3,
        ]);

        $this->createOfferFor(
            $product->first()
        );
    }

    protected function createOfferFor($product)
    {
        $faker = Faker::create();

        $price = $faker->numberBetween(1, 99);
        $stock = $faker->numberBetween(20, 50);
        $percentage = $faker->randomElement([10, 15, 25, 35, 50]);

        ProductOffer::create([
            'day_end' => $faker->dateTimeBetween('now', '+1 years'),
            'price' => (($percentage * $price) / 100),
            'day_start' => $faker->dateTime(),
            'quantity' => round($stock / 2),
            'product_id' => $product->id,
            'percentage' => $percentage,
        ]);
    }
}
