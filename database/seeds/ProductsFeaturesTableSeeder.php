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
use Antvel\Product\Features\Models\ProductFeatures;

class ProductsFeaturesTableSeeder extends Seeder
{
    public function run()
    {
        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.weight'),
            'product_type' => 'item',
        ]);

        factory(ProductFeatures::class)->create([
            'name' => 'virtual size',
            'product_type' => 'key',
        ]);

        factory(ProductFeatures::class)->create([
            'name' => 'os',
            'product_type' => 'key',
        ]);

        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.dimensions'),
            'product_type' => 'item',
        ]);

        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.color'),
            'product_type' => 'item',
        ]);

        factory(ProductFeatures::class)->create([
            'name' => trans('globals.product_features.model'),
            'product_type' => 'item',
        ]);
    }
}
