<?php

/*
 * This file is part of the Antvel e-commerce.
 *
 * (c) Gustavo Ocanto <gustavoocanto@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Http\Controllers;

use Antvel\Orders\Models\Order;
use App\Http\Controllers\Controller;
use Antvel\Product\Suggestions\Suggest;

class HomeController extends Controller
{
    /**
     * Shows the home page.
     *
     * @return void
     */
    public function index()
    {
        $suggestion = Suggest::for('product_viewed', 'product_purchased' , 'product_categories')->shake();

        $suggestion['carousel'] = $suggestion['product_purchased'];

        return view('home', [
            'banner' => ['/images/banner.jpg', '/images/banner.jpg', '/images/banner.jpg', '/images/banner.jpg'], //while refactoring
            'tagsCloud' => $this->tagsCloud($suggestion),
            'suggestion' => $suggestion,
            'events' => [],
        ]);
    }

    /**
     * Returns a tags array based upon the given suggestions.
     *
     * @param  array $suggestion
     *
     * @return array
     */
    protected function tagsCloud($suggestion) : array
    {
        return collect($suggestion)->map(function ($item) {
            $tags[] = explode(',', $item->pluck('tags')->implode(','));
            return $tags;
        })->flatten()->unique()->all();
    }

    //moved here while refactoring
    public function summary()
    {
        $panel =  [
            'left'   => ['width' => '2', 'class' => 'user-panel'],
            'center' => ['width' => '10'],
        ];

        $query = Order::where('user_id', auth()->user()->id)->ofType('order')->get();
        $orders = ['closed' => 0, 'open' => 0, 'cancelled' => 0, 'all' => $query->count(), 'total' => 0, 'nopRate' => 0];

        foreach ($query as $row) {
            if ($row->status == 'cancelled') {
                $orders['cancelled']++;
            } elseif ($row->status == 'closed') {
                $orders['closed']++;
            } else {
                $orders['open']++;
            }
            foreach ($row->details as $deta) {
                $orders['total'] += ($deta->quantity * $deta->price);
                if ($row->status == 'closed' && !$deta->rate) {
                    $orders['nopRate']++;
                }
            }
        }
        unset($query);
        $sales = null;
        if (\Auth::check() && \Auth::user()->hasRole(['business', 'admin'])) {
            $orders = Order::where('seller_id', \Auth::user()->id)->ofType('order')->get();
            $sales = ['closed' => 0, 'open' => 0, 'cancelled' => 0, 'all' => $orders->count(), 'total' => 0, 'rate' => 0, 'numRate' => 0, 'totalRate' => 0, 'nopRate' => 0];
            foreach ($orders as $row) {
                if ($row->status == 'cancelled') {
                    $sales['cancelled']++;
                } elseif ($row->status == 'closed') {
                    $sales['closed']++;
                } else {
                    $sales['open']++;
                }
                foreach ($row->details as $deta) {
                    $sales['total'] += ($deta->quantity * $deta->price);
                    if ($row->status == 'closed' && $deta->rate) {
                        $sales['numRate']++;
                        $sales['totalRate'] = $sales['totalRate'] + $deta->rate;
                    }
                    if ($row->status == 'closed' && !$deta->rate) {
                        $sales['nopRate']++;
                    }
                }
            }
            if ($sales['numRate']) {
                $sales['rate'] = $sales['totalRate'] / $sales['numRate'];
            }
        }

        return view('users.summary', compact('panel', 'orders', 'sales'));
    }
}
