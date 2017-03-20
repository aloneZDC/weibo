<?php

namespace App\Http\Controllers\Auth;

use Antvel\User\Auth\Login;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Antvel\User\Requests\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * The Antvel sessions driver.
     *
     * @var Login
     */
    protected $antvel = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Login $antvel)
    {
        $this->middleware('guest', ['except' => 'logout']);

        $this->antvel = $antvel;
    }

    /**
     * Process the user login.
     *
     * @param  Request $request
     * @return void
     */
    public function login(LoginRequest $request)
    {
        return $this->antvel->authenticate($request);
    }
}
