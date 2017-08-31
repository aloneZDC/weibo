<?php

namespace App\Helpers;

/*
 * Antvel - App Menus Helper
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use Antvel\Orders\Models\Order;
use Antvel\Product\Models\Product;

class Menu
{
    /**
     * Sidebar menu.
     *
     * @param  boolean $returnArray
     *
     * @return mixed
     */
    public static function summary($returnArray = false)
    {
        $menu = [
            ['route' => '/summary', 'text' => trans('user.summary'), 'icon' => 'glyphicon glyphicon-stats'],
            ['route' => route('user.index'), 'text' => trans('user.profile'), 'icon' => 'glyphicon glyphicon-user'],
            ['route' => route('addressBook.index'), 'text' => trans('user.address_book'), 'icon' => 'glyphicon glyphicon-map-marker', 'divider' => 1],
        ];

        if (auth()->check() && auth()->user()->isAdmin()) {
            $menu = array_merge($menu, [
                ['route' => route('dashboard.home'), 'text' => trans('globals.dashboard'), 'icon' => 'glyphicon glyphicon-dashboard'],
                ['route' => route('orders.pendingOrders'), 'text' => trans('user.your_sales'), 'icon' => 'glyphicon glyphicon-piggy-bank'],
            ]);
        }

        else {
            $menu[] = ['route' => '/user/orders', 'text' => trans('user.your_orders'), 'icon' => 'glyphicon glyphicon-shopping-cart', 'divider' => 1];
        }

        return $returnArray ? $menu : json_encode($menu);
    }

    /**
     * Top menu
     *
     * @param  boolean $returnArray
     *
     * @return mixed
     */
    public static function top($returnArray = false)
    {
        if (\Auth::guest()) {
            $menu = [
                ['route' => '/login', 'text' => trans('user.login'), 'divider' => 1],
                ['route' => '/register', 'text' => trans('user.register')],
            ];
        } else {
            $menu = self::summary(true);
        }

        return $returnArray ? $menu : json_encode($menu);
    }

    /**
     * Help menu.
     *
     * @param  boolean $returnArray
     *
     * @return mixed
     */
    public static function help($returnArray = false)
    {
        $menu = [
            ['route' => '/about', 'text' => trans('company.about_us')],
            ['route' => '/refunds', 'text' => trans('company.refund_policy')],
            ['route' => '/privacy', 'text' => trans('company.privacy_policy')],
            ['route' => '/terms', 'text' => trans('company.terms_of_service'), 'divider' => 1],
            ['route' => '/contact', 'text' => trans('about.contact_us')],
        ];

        return $returnArray ? $menu : json_encode($menu);
    }
}
