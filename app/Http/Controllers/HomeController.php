<?php

namespace App\Http\Controllers;

/*
 * Antvel - Home Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use Antvel\Product\Products;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
   /**
     * The products repository.
     *
     * @var Products
     */
    protected $products = null;

    /**
     * The suggestion keys.
     *
     * @var array
     */
    protected $listing = ['product_viewed', 'product_purchased' , 'product_categories'];

    /**
     * Creates a new instance.
     *
     * @param Products $products
     *
     * @return void
     */
    public function __construct(Products $products)
    {
        $this->products = $products;
    }

    /**
     * Shows the home page.
     *
     * @return void
     */
    public function index()
    {
        $suggestion = $this->products->suggestForPreferences($this->listing);

        $suggestion['carousel'] = $suggestion['product_purchased'];

        return view('home', [
            'banner' => ['/img/banner/01.png', '/img/banner/02.png', '/img/banner/03.png', '/img/banner/04.png'], //while refactoring
            'tagsCloud' => $this->tagsCloud($suggestion),
            'panel' => $this->panelLayout(),
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

    /**
     * Returns the panel layout.
     *
     * @return array
     */
    protected function panelLayout()
    {
        return [
            'center' => [
                'width' => 10,
            ],
            'left' => [
                'width' => 2,
                'class' => 'home-no-padding',
            ],
        ];
    }

    //moved here while refactoring
    public function dashBoard()
    {
        $panel =  [
            'left'   => ['width' => '2', 'class' => 'user-panel'],
            'center' => ['width' => '10'],
        ];
        $query = Product::where('user_id', \Auth::id())->Free()->get();
        $products = ['active' => 0, 'inactive' => 0, 'lowStock' => 0, 'all' => $query->count()];
        foreach ($query as $row) {
            if ($row->status) {
                $products['active']++;
            } else {
                $products['inactive']++;
            }
            if ($row->stock <= $row->low_stock) {
                $products['lowStock']++;
            }
        }
        unset($query);
        $query = Order::auth()->ofType('order')->get();
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

        return view('user.dashboard', compact('panel', 'products', 'orders', 'sales'));
    }
}
