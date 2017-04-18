<?php

namespace app\Http\Controllers;

/*
 * Antvel - Admin Panel Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Http\Controllers\Controller;

class WpanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $panel = [
            'left'   => ['width' => '2'],
            'center' => ['width' => '10'],
        ];

        return view('wpanel.home', compact('panel'));
    }
}
