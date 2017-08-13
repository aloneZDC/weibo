<?php

namespace App\Http\Controllers;

/*
 * Antvel - Products Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Order;
use App\OrderDetail;

//shop components.
use Antvel\Product\Models\Product;
use Antvel\Features\Models\Feature;
use App\Http\Controllers\Controller;
use Antvel\Categories\Models\Category;
use Antvel\Product\Suggestions\Suggest;
use Antvel\Product\Repositories\ProductsRepository;

class ProductsController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(Product $product)
    {
        $product->load('group', 'category');

        //increasing product counters, in order to have a suggestion orden
        (new ProductsRepository)->increment('view_counts', $product);

        //saving the product tags into users preferences
        if (trim($product->tags) != '' && auth()->check()) {
            auth()->user()->updatePreferences('product_viewed', $product->tags);
        }

        return view('products.detailProd', [
            'suggestions' => Suggest::for('product_viewed')->shake()->get('product_viewed'),
            'reviews' => OrderDetail::ReviewsFor($product->id),
            'allWishes' => Order::forSignedUser('wishlist'),
            'features' => Feature::filterable()->get(),
            'product' => $product,
        ]);
    }
}
