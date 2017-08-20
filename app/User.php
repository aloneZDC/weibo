<?php

namespace App;

/*
 * Antvel - Users Model
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Order;
use Antvel\User\Models\User as BaseUser;

class User extends BaseUser
{
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    //Cart Manage
    public function getCartCount()
    {
        $basicCart = Order::ofType('cart')->where('user_id', $this->id)->first();
        if (!($basicCart)) {
            return 0;
        } else {
            $totalItems = 0;
            foreach ($basicCart->details  as $orderDetail) {
                $totalItems += $orderDetail->quantity;
            }

            return $totalItems;
        }
    }

    public function getCartContent()
    {
        $shoppingCart = Order::ofType('cart')->where('user_id', $this->id)->first();

        if ($shoppingCart) {
            return $shoppingCart->details->sortByDesc('created_at')->take(5);
        }

        return [];
    }
}
