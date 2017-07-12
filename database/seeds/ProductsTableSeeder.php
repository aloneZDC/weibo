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
use Antvel\Product\Models\{ Product, ProductPictures };

class ProductsTableSeeder extends Seeder
{
    public function run()
    {
        for ($i=1; $i < 150; $i++) {
            $product = factory(Product::class)->create();

            factory(ProductPictures::class, 5)->create([
                'product_id' => $product->id
            ]);
        }
    }
}
