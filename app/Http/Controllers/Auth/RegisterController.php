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
use Antvel\Users\Policies\Roles;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Antvel\Users\Notifications\RegistrationNotification;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

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
     * Show the registration form.
     *
     * @return void
     */
    protected function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $data = $request->validate($this->rules(
            $request->all()
        ));

        $user = $this->create($data);

        session()->flash('message', trans('user.signUp_message', ['_name' => $user->full_name]));

        return redirect($this->redirectTo);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function rules()
    {
        return [
            'email' => 'required|email|max:255|unique:users',
            'first_name' => 'required|max:20|min:3',
            'last_name' => 'required|max:20|min:3',
            'password' => 'required|min:6',
        ];
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create(array_merge($data, [
            'confirmation_token' => str_limit(md5($data['email'] . str_random()), 25, ''),
            'image' => '/images/no-avatar.png',
            'nickname' => $data['email'],
            'role' => Roles::default(),
        ]));

        $this->sendEmailVerification($user);

        return $user;
    }

    /**
     * We send an email to the given user with a link to confirm his account.
     *
     * @param  \App\User $user
     *
     * @return void
     */
    protected function sendEmailVerification(User $user)
    {
        $user->notify(new RegistrationNotification([
            'subject' => trans('user.emails.verification_account.subject'),
            'view' => 'emails.accountVerification',
        ]));
    }
}
