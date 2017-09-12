<?php

/*
 * This file is part of the Antvel e-commerce.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AccountConfirmationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Confirms the user related to the given token & email.
     *
     * @return void
     */
    public function update($token, $email)
    {
        try {
            $user = User::confirm($token, $email);
        } catch (ModelNotFoundException $e) {
            abort(404);
        }

        Auth::login($user);

        return redirect(route('home'));
    }
}
