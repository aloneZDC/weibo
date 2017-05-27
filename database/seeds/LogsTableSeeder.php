<?php

/*
 * This file is part of the Antvel App package.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use App\ActionType;
use App\Log;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class LogsTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $actions = ActionType::get();
        $users = User::select('id')->get();
        //Category
        foreach (range(1, 20) as $void) {
            Log::create([
                'user_id'        => $users->random(1)->first()->id,
                'action_type_id' => $actions->random(1)->first()->id,
                'source_id'      => $faker->numberBetween(50, 1000000),
                'details'        => $faker->text(50),
            ]);
        }
    }
}
