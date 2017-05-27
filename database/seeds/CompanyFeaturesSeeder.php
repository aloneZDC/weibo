<?php

/*
 * This file is part of the Antvel App package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\Company;
use App\CompanyFeatures;
use Illuminate\Database\Seeder;

class CompanyFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $company = Company::find('1');
        CompanyFeatures::create([
            'company_id'  => $company->id,
            'description' => trans('globals.freeproducts'),
        ]);
    }
}
