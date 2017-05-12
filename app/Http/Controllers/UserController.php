<?php

namespace App\Http\Controllers;

/*
 * Antvel - Users Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function getPoints()
    {
        $points = ['points' => '0'];
        $user = \Auth::user();
        if ($user) {
            $points = ['points' => $user->current_points];
        }

        return \Response::json($points);
    }
}
