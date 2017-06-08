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
use Antvel\Product\Models\ProductFeatures;

class ProductsFeaturesTableSeeder extends Seeder
{
    public function run()
    {
        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.weight')
        ]);

        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.dimensions')
        ]);

        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.color')
        ]);

        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.model')
        ]);
    }
}
