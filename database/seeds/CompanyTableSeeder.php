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
use Antvel\Companies\Models\Company;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Company::class)->create([
            'name' => 'antvel',
            'description' => 'Laravel e-commerce Application',
            'email' => 'info@antvel.com',
            'contact_email' => 'contact@antvel.com',
            'sales_email' => 'sales@antvel.com',
            'support_email' => 'support@antvel.com',
            'website' => 'http://antvel.com',
            'twitter' => 'https://twitter.com/_antvel',
            'facebook' => 'https://www.facebook.com/antvelecommerce',
            'default' => true,
        ]);
    }
}
