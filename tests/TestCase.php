<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Returns a testing user.
     *
     * @param  integer $id
     * @return User
     */
    public function user($id = 1) : User
    {
    	return User::where('id', 3)->first();
    }
}
