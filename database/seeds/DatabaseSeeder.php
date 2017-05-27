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
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(UsersTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(AddressBookTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call('ProductsDetailTableSeeder');
        $this->call(ProductsFeaturesTableSeeder::class);
        $this->call('OrdersTableSeeder');
        $this->call('ProductsRatesSeeder');
        $this->call('LogsTableSeeder');
        $this->call('CommentsTableSeeder');
        $this->call('VirtualProductsSeeder');
        $this->call('CompanyTableSeeder');
        $this->call('CompanyFeaturesSeeder');

        if (config('app.offering_free_products')) {
            $this->call('FreeProductsTableSeeder');
        }
    }
}
