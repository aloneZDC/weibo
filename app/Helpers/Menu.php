<?php

namespace App\Helpers;

/*
 * Antvel - App Menus Helper
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Order;
use Antvel\Product\Models\Product;

class Menu
{
    /**
     * [Menu Dashboard ].
     *
     * @param  bool para indicar el tipo de salida, json o array
     *
     * @return [json o array]
     *               Nota: el contenido del array interno de contener al menos route y text lo demas es opcional
     *               //[route,text,cont(para badge), divider, class, icon  ]
     */
    public static function dashboard($returnArray = false)
    {
        $menu = [
            ['route' => '/dashboard', 'text' => trans('user.dashboard'), 'icon' => 'glyphicon glyphicon-dashboard'],
            ['route' => route('user.index'), 'text' => trans('user.profile'), 'icon' => 'glyphicon glyphicon-user'],
            ['route' => route('addressBook.index'), 'text' => trans('user.address_book'), 'icon' => 'glyphicon glyphicon-map-marker', 'divider' => 1],
        ];

        if (auth()->check() && auth()->user()->hasRole(['seller', 'admin'])) { //will move to the foundation panel
            $products = Product::get();
            $productsLowStock = 0;
            foreach ($products as $row) {
                if ($row->stock <= $row->low_stock) {
                    $productsLowStock++;
                }
            }

            $salesOpen = Order::where('seller_id', \Auth::user()->id)
                ->ofType('order')
                ->whereNotIn('status', ['cancelled', 'closed'])
                ->get()
                ->count();

            $menu = array_merge($menu, [
                ['route' => route('users.products'), 'text' => trans('user.your_products'), 'icon' => 'glyphicon glyphicon-briefcase', 'cont' => $productsLowStock],
                ['route' => '/orders/usersOrders', 'text' => trans('user.your_sales'), 'icon' => 'glyphicon glyphicon-piggy-bank', 'cont' => $salesOpen],
            ]);
        }

        if (auth()->check() && auth()->user()->hasRole(['customer', 'admin'])) {
            $menu[] = ['route' => '/user/orders', 'text' => trans('user.your_orders'), 'icon' => 'glyphicon glyphicon-shopping-cart', 'divider' => 1, 'cont' => 0];
        }

        if (config('app.offering_free_products')) {
            $menu[] = ['route' => '/user/myFreeProducts', 'text' => trans('user.your_free_products'), 'icon' => 'glyphicon glyphicon-star'];
        }

        return $returnArray ? $menu : json_encode($menu);
    }

    /**
     * [Menu Top ].
     *
     * @param  bool para indicar el tipo de salida, json o array
     *
     * @return [json o array]
     *               Nota: el contenido del array interno de contener al menos route y text lo demas es opcional
     *               //[route,text,cont(para badge), divider, class, icon  ]
     *               Este menu carga el menu del Dashboard
     */
    public static function top($returnArray = false)
    {
        if (\Auth::guest()) { // invidados
            $menu = [
                ['route' => '/login', 'text' => trans('user.login'), 'divider' => 1],
                ['route' => '/register', 'text' => trans('user.register')],
            ];
        } else {  // logeado
            $menu = self::dashboard(true);

            //-- Web Panel(Only for admim) --
            if (\Auth::check() && \Auth::user()->isAdmin()) {
                $menu = array_merge($menu, [
                    ['route' => '/wpanel', 'text' => trans('user.wpanel'), 'icon' => 'glyphicon glyphicon-cog', 'divider' => 1],
                ]);
            }
        }

        return $returnArray ? $menu : json_encode($menu);
    }

    /**
     * [Menu backend ].
     *
     * @param  bool para indicar el tipo de salida, json o array
     *
     * @return [json o array]
     *               Nota: el contenido del array interno de contener al menos route y text lo demas es opcional
     *               //[route,text,cont(para badge), divider, class, icon  ]
     */
    public static function backend($returnArray = false)
    {
        //Menu para empresas
        if (\Auth::user()->hasRole(['seller', 'admin'])) {
            $menu = [
                ['route' => '/wpanel',            'text' => trans('user.dashboard'),              'icon' => 'glyphicon glyphicon-dashboard'],
                ['route' => '/wpanel/profile',    'text' => trans('company.store_config'),        'icon' => 'glyphicon glyphicon-cog'],
                ['route' => '/wpanel/productsdetails',   'text' => trans('features.product_features'),   'icon' => 'glyphicon glyphicon-th-list'],
            ];
        }

        return $returnArray ? $menu : json_encode($menu);
    }

    /**
     * [Menu help ].
     *
     * @param  bool para indicar el tipo de salida, json o array
     *
     * @return [json o array]
     *               Nota: el contenido del array interno de contener al menos route y text lo demas es opcional
     *               //[route,text,cont(para badge), divider, class, icon  ]
     */
    public static function help($returnArray = false)
    {
        //Menu para empresas

            $menu = [
                // ['route' =>'#',      'text'=> trans('globals.faq'),   ],
                ['route' => '/about', 'text' => trans('company.about_us')],
                ['route' => '/refunds', 'text' => trans('company.refund_policy')],
                ['route' => '/privacy', 'text' => trans('company.privacy_policy')],
                ['route' => '/terms', 'text' => trans('company.terms_of_service'), 'divider' => 1],
                ['route' => '/contact', 'text' => trans('about.contact_us')],
            ];

        return $returnArray ? $menu : json_encode($menu);
    }
}
