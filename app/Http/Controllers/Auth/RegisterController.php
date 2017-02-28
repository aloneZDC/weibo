<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Antvel\Components\Customer\Register;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * The Antvel sessions driver.
     *
     * @var Antvel\Components\Customer\Register
     */
    protected $antvel = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Register $antvel)
    {
        $this->middleware('guest');

        $this->antvel = $antvel;
    }

    /**
     * Show the registration form.
     *
     * @return void
     */
    protected function showRegistrationForm()
    {
        return view('auth.register', [
            'email' => session()->has('email') ? session()->get('email') : ''
        ]);
    }

    /**
     * Process the user registration.
     *
     * @return void
     */
    protected function register(Request $request)
    {
        $this->antvel->register($request)
            ->withRegistrationEmail([
                'subject' => trans('user.emails.verification_account.subject')
            ]);

        session()->flash('message', trans('user.signUp_message', [
            '_name' => $request->get('first_name') . ' ' . $request->get('last_name')
        ]));

        return redirect($this->redirectTo);
    }

    /**
     * Confirms the user subscription.
     *
     * @param  string $token
     * @param  string $email
     * @return void
     */
    protected function confirm($token, $email)
    {
        try {

            $user = $this->antvel->validateConfirmation($token, $email)->activateUser();
            auth()->login($user);
            return redirect('/');

        } catch (\Exception $e) {

            session()->flash('message', trans('user.account_verified_error_message'));
            return redirect($this->redirectTo);

        };
    }
}