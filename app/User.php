<?php

namespace App;

/*
 * Antvel - Users Model
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use Antvel\Orders\Models\Order;
use Antvel\User\Models\User as BaseUser;

class User extends BaseUser
{
    /**
     * The user's orders. | while refactoring
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * The user's shopping cart. | while refactoring
     *
     * @return mixed
     */
    public function shoppingCart()
    {
        $shoppingCart = $this->orders()->with('details')
            ->where('type', 'cart')
            ->first();

        return is_null($shoppingCart) ? collect() : $shoppingCart->details;
    }
}
