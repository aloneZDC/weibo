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
use Antvel\Product\Models\{ Product, ProductPictures };

class GroupingSeeder extends Seeder
{
    public function run()
    {
    	$products = Product::whereIn('id', [2, 3, 4, 5])->get();

    	Product::first()->groupWith($products);
    }
}
