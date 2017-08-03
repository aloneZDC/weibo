<?php

namespace App\Http\Controllers;

/*
 * Antvel - Products Controller
 *
 * @author  Gustavo Ocanto <gustavoocanto@gmail.com>
 */

use App\Order;
use App\OrderDetail;
use App\Helpers\File;
use App\ProductDetail;
use App\VirtualProduct;
use App\FreeProductOrder;
use Illuminate\Http\Request;
use App\Helpers\FeaturesHelper; //WIP
use App\Helpers\ProductsHelper;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

//shop components.
use App\User;
use Antvel\Product\Models\Product;
use Antvel\Categories\Models\Category;
use Antvel\Product\Suggestions\Suggest;

class ProductsController extends Controller
{
    private $form_rules = [
        'amount'       => 'required|numeric|digits_between:1,11|min:0',
        'bar_code'     => 'max:255',
        'category_id'  => 'required',
        'condition'    => 'required',
        'description'  => 'required|max:500',
        'key'          => 'required',
        'key_software' => 'required',
        'type'         => 'required',
        'low_stock'    => 'numeric|digits_between:1,11|min:0',
        'name'         => 'required|max:100',
        'price'        => 'required|numeric|digits_between:1,10|min:1',
        'software'     => 'required',
        'software_key' => 'required',
        'stock'        => 'required|numeric|digits_between:1,11|min:0',
    ];
    private $panel = [
        'left'   => ['width' => '2'],
        'center' => ['width' => '10'],
    ];

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $product = Product::find(-50);
        $features = ProductDetail::all()->toArray();
        $arrayCategories = Category::actives()->get()->toArray();

        $categories = [
            '' => trans('product.controller.select_category'),
        ];

        $condition = [
            'new'         => trans('product.controller.new'),
            'refurbished' => trans('product.controller.refurbished'),
            'used'        => trans('product.controller.used'),
        ];

        $typesProduct = [
            'item' => trans('product.controller.item'),
            'key'  => trans('product.globals.digital_item').' '.trans('product.globals.key'),
        ];

        $typeItem = 'item';

        //categories drop down formatted
        ProductsHelper::categoriesDropDownFormat($arrayCategories, $categories);

        $disabled = '';
        $edit = false;
        $panel = $this->panel;
        $oldFeatures = ProductDetail::oldFeatures([]);
        $productsDetails = new FeaturesHelper();

        return view('products.form',
                compact('product', 'panel', 'features', 'categories', 'condition', 'typeItem', 'typesProduct', 'disabled', 'edit', 'oldFeatures', 'productsDetails'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        if (!$request->input('type')) {
            return redirect()->back()
            ->withErrors(['induced_error' => [trans('globals.error').' '.trans('globals.induced_error')]]);
        }

        $rules = $this->rulesByTypes($request);
        $v = Validator::make($request->all(), $rules);

        if ($v->fails()) {
            return redirect()->back()
            ->withErrors($v->errors())->withInput();
        }

        $features = $this->validateFeatures($request->all());
        if (!is_string($features)) {
            return redirect()->back()
            ->withErrors($features)->withInput();
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->category_id = $request->input('category_id');
        $product->created_by = \Auth::id();
        $product->updated_by = \Auth::id();
        $product->description = $request->input('description');
        $product->bar_code = $request->input('bar_code');
        $product->brand = $request->input('brand');
        $product->price = $request->input('price');
        $product->condition = $request->input('condition');
        $product->features = $features;
        $product->type = $request->input('type');
        if ($request->input('type') == 'item') {
            $product->stock = $request->input('stock');
            $product->low_stock = $request->input('low_stock');
            if ($request->input('stock') > 0) {
                $product->status = $request->input('status');
            } else {
                $product->status = 0;
            }
        } else {
            $product->status = $request->input('status');
        }
        $product->save();
        $message = '';
        if ($request->input('type') != 'item') {
            switch ($request->input('type')) {
                case 'key':
                    $num = 0;
                    if (!Storage::disk('local')->exists($request->input('key'))) {
                        return redirect()->back()
                        ->withErrors(['induced_error' => [trans('globals.file_does_not_exist')]])->withInput();
                        // ->withErrors(array('induced_error'=>array(storage_path().'files/key_code'.$request->input('key'))))->withInput();
                    }
                    $contents = Storage::disk('local')->get($request->input('key'));
                    $contents = explode("\n", rtrim($contents));
                    $warning = false; $len = 0;
                    $virtualProduct = new virtualProduct();
                    $virtualProduct->product_id = $product->id;
                    $virtualProduct->key = 'undefined';
                    $virtualProduct->status = 'cancelled';
                    $virtualProduct->save();
                    foreach ($contents as $row) {
                        $virtualProduct = new virtualProduct();
                        $virtualProduct->product_id = $product->id;
                        $virtualProduct->status = 'open';
                        $virtualProduct->key = $row;
                        $virtualProduct->save();
                        $num++;
                        if ($len == 0) {
                            $len = strlen(rtrim($row));
                        } elseif (strlen(rtrim($row)) != $len) {
                            $warning = true;
                        }
                    }
                    $product->stock = $num;
                    if ($num == 0) {
                        $product->status = 0;
                    }
                    $product->save();
                    $message = ' '.trans('product.controller.review_keys');
                    if ($warning) {
                        $message .= ' '.trans('product.controller.may_invalid_keys');
                    }
                    Storage::disk('local')->deleteDirectory('key_code/'.\Auth::id());
                break;
                case 'software':
                break;
                case 'software_key':
                break;
                case 'gift_card':
                break;
            }
        }
        Session::flash('message', trans('product.controller.saved_successfully').$message);

        return redirect('products/'.$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = \Auth::user();
        $allWishes = '';
        $panel = [
            'center' => [
                'width' => '12',
            ],
        ];

        if ($user) {
            $allWishes = Order::ofType('wishlist')
                // ->where('user_id', $user->id)
                ->where('description', '<>', '')
                ->orderBy('id', 'desc')
                ->take(5)
                ->get();
        }

        $product = Product::with([
            'group' => function ($query) {
                $query->select(['id', 'products_group', 'features']);
            },
        ])->with('category')->find($id);

        if ($product) {

            //if there is a user in session, the admin menu will be shown
            if ($user && in_array($user->role, ['admin', 'seller'])) {
                $panel = [
                    'left'   => ['width' => '2'],
                    'center' => ['width' => '10'],
                ];
            }

            //retrieving products features
            $features = ProductDetail::all()->toArray();

            //increasing product counters, in order to have a suggestion orden
            $this->setCounters($product, ['view_counts' => trans('globals.product_value_counters.view')], 'viewed');

            //saving the product tags into users preferences
            if (trim($product->tags) != '' && auth()->check()) {
                auth()->user()->updatePreferences('product_viewed', $product->tags);
            }

            //receiving products user reviews & comments
            $reviews = OrderDetail::where('product_id', $product->id)
                ->whereNotNull('rate_comment')
                ->select('rate', 'rate_comment', 'updated_at')
                ->orderBy('updated_at', 'desc')
                ->take(5)
                ->get();

            //If it is a free product, we got to retrieve its package information
            if ($product->type == 'freeproduct') {
                $order = OrderDetail::where('product_id', $product->id)->first();
                $freeproduct = FreeProductOrder::where('order_id', $order->order_id)->first();
            }

            $freeproductId = isset($freeproduct) ? $freeproduct->freeproduct_id : 0;

            $suggestions = Suggest::for('product_viewed')->shake()->get('product_viewed');

            //retrieving products groups of the product shown
            if (count($product->group)) {
                $product->group = (new FeaturesHelper())->group($product->group);
            }

            return view('products.detailProd', compact('product', 'panel', 'allWishes', 'reviews', 'freeproductId', 'features', 'suggestions'));
        } else {
            return redirect(route('products.index'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $product = Product::find($id);

        $typeItem = $product->type;
        $disabled = '';

        $order = OrderDetail::where('product_id', $id)
            ->join('orders', 'order_details.order_id', '=', 'orders.id')
            ->first();

        if ($order) {
            $disabled = 'disabled';
        }

        $features = ProductDetail::all()->toArray();

        $allCategoriesStore = Category::actives()->get()->toArray();

        $categories = ['' => trans('product.controller.select_category')];

        //categories drop down formatted
        ProductsHelper::categoriesDropDownFormat($allCategoriesStore, $categories);

        $condition = ['new' => trans('product.controller.new'), 'refurbished' => trans('product.controller.refurbished'), 'used' => trans('product.controller.used')];

        $edit = true;
        $panel = $this->panel;

        $oldFeatures = ProductDetail::oldFeatures($product->features);

        $productsDetails = new FeaturesHelper();

        return view('products.form', compact('product', 'panel', 'features', 'categories', 'condition', 'typeItem', 'disabled', 'edit', 'oldFeatures', 'productsDetails'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id, Request $request)
    {
        if (!$request->input('type')) {
            return redirect()->back()
            ->withErrors(['induced_error' => [trans('globals.error').' '.trans('globals.induced_error')]])->withInput();
        }
        $rules = $this->rulesByTypes($request, true);
        $order = OrderDetail::where('product_id', $id)->join('orders', 'order_details.order_id', '=', 'orders.id')->first();
        if ($order) {
            unset($rules['name']);
            unset($rules['category_id']);
            unset($rules['condition']);
        }
        $v = Validator::make($request->all(), $rules);
        if ($v->fails()) {
            return redirect()->back()
            ->withErrors($v->errors())->withInput();
        }
        $features = $this->validateFeatures($request->all());
        if (!is_string($features)) {
            return redirect()->back()
            ->withErrors($features)->withInput();
        }
        $product = Product::find($id);
        // if (\Auth::id() != $product->user_id) {
        //     return redirect('products/'.$product->user_id)->withErrors(['feature_images' => [trans('globals.not_access')]]);
        // }
        if (!$order) {
            $product->name = $request->input('name');
            $product->category_id = $request->input('category_id');
            $product->condition = $request->input('condition');
        }
        $product->status = $request->input('status');
        $product->description = $request->input('description');
        $product->bar_code = $request->input('bar_code');
        $product->brand = $request->input('brand');
        $product->price = $request->input('price');
        $product->features = $features;
        $product->updated_by = \Auth::id();
        if ($request->input('type') == 'item') {
            $product->stock = $request->input('stock');
            $product->low_stock = $request->input('low_stock');
            if ($request->input('stock') > 0) {
                $product->status = $request->input('status');
            } else {
                $product->status = 0;
            }
        } else {
            $product->status = $request->input('status');
        }
        $product->save();
        $message = '';
        if ($request->input('type') != 'item') {
            switch ($request->input('type')) {
                case 'key':
                    if ($request->input('key') != '' && Storage::disk('local')->exists('key_code'.$request->input('key'))) {
                        $contents = Storage::disk('local')->get('key_code'.$request->input('key'));
                        $contents = explode("\n", rtrim($contents));
                        $warning = false;
                        $len = 0;
                        foreach ($contents as $row) {
                            $virtualProduct = new virtualProduct();
                            $virtualProduct->product_id = $product->id;
                            $virtualProduct->key = $row;
                            $virtualProduct->status = 'open';
                            $virtualProduct->save();
                            if ($len == 0) {
                                $len = strlen(rtrim($row));
                            } elseif (strlen(rtrim($row)) != $len) {
                                $warning = true;
                            }
                        }
                        $stock = count(VirtualProduct::where('product_id', $product->id)->where('status', 'open')->get()->toArray());
                        $product->stock = $stock;
                        if ($stock == 0) {
                            $product->status = 0;
                        }
                        $product->save();
                        $message = ' '.trans('product.controller.review_keys');
                        if ($warning) {
                            $message .= ' '.trans('product.controller.may_invalid_keys');
                        }
                        Storage::disk('local')->deleteDirectory('key_code/'.\Auth::id());
                    }
                break;
                case 'software':

                break;
                case 'software_key':

                break;
                case 'gift_card':

                break;
            }
        }
        Session::flash('message', trans('product.controller.saved_successfully').$message);

        return redirect('products/'.$product->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        // if (\Auth::id() != $product->user_id) {
        //     return redirect('products/'.$product->user_id)->withErrors(['feature_images' => [trans('globals.not_access')]]);
        // }
        $product->status = 0;
        $product->save();
        Session::flash('message', trans('product.controller.saved_successfully'));

        return redirect('products/'.$product->id);
    }

    /**
     * Change status a Product.
     *
     * @param int $id
     *
     * @return Response
     */
    public function changeStatus($id)
    {
        $product = Product::select('id', 'features', 'status', 'type')->find($id);
        // if (\Auth::id() != $product->user_id) {
        //     return redirect('products/'.$product->user_id)->withErrors(['feature_images' => [trans('globals.not_access')]]);
        // }
        $product->status = ($product->status) ? 0 : 1;
        $product->save();
        Session::flash('message', trans('product.controller.saved_successfully'));

        return redirect('products/'.$product->id);
    }

    /**
     *   upload image file.
     *
     *   @param Resquest     file to upload
     *
     *   @return string
     */
    public function upload(Request $request)
    {
        $v = Validator::make($request->all(), ['file' => 'image']);
        if ($v->fails()) {
            return $v->errors()->toJson();
        }

        return File::section('product_img')->upload($request->file('file'));
    }

    /**
     *   delete image file.
     *
     *   @param Resquest     file to upload
     *
     *   @return string
     */
    public function deleteImg(Request $request)
    {
        return File::deleteFile($request->get('file'));
    }

    /**
     *   upload the keys file in txt format.
     *
     *   @param Resquest     file to upload
     *
     *   @return string
     */
    public function upload_key(Request $request)
    {
        $v = Validator::make($request->all(), ['file' => 'mimes:txt']);
        if ($v->fails()) {
            return $v->errors()->toJson();
        }

        return File::section('product_key')->upload($request->file('file'));
    }

    /**
     *   upload the software file in txt format.
     *
     *   @param Resquest     file to upload
     *
     *   @return string
     */
    public function upload_software(Request $request)
    {
        $v = Validator::make($request->all(), ['file' => 'mimes:zip,rar']);
        if ($v->fails()) {
            return $v->errors()->toJson();
        }

        return 'README.7z';

        return File::section('product_software')->upload($request->file('file'));
    }

    /**
     *   dowload file txt example.
     *
     *   @param Resquest     file to upload
     *
     *   @return string
     */
    public function downloadExample()
    {
        return response()->download(storage_path().'/files/key_code/example_keys.txt', 'file.txt');
    }

    /**
     *   validate product feature, as specified in the table of product details.
     *
     *   @param [array] $data all inputs
     *
     *   @return [string|array]
     */
    private function validateFeatures($data)
    {
        $features = ProductDetail::all()->toArray();
        $features_rules = [];
        $message_rules = [];
        foreach ($features as $row) {
            if ($row['status'] == 'active' && $row['validationRulesArray']) {
                if ($row['max_num_values'] * 1 == 1) {
                    $features_rules['feature_'.$row['indexByName']] = $row['validationRulesArray'][$row['indexByName'].'_1'] ? $row['validationRulesArray'][$row['indexByName'].'_1'] : '';
                    $message_rules = array_merge($message_rules, $this->validationMessagesFeatures($row['validationRulesArray'][$row['indexByName'].'_1'], 'feature_'.$row['indexByName'], $row['upperName']));
                } else {
                    for ($i = 1; $i <= ($row['max_num_values'] * 1); $i++) {
                        $features_rules['feature_'.$row['indexByName'].'_'.$i] = $row['validationRulesArray'][$row['indexByName'].'_'.$i] ? $row['validationRulesArray'][$row['indexByName'].'_'.$i] : '';
                        $message_rules = array_merge($message_rules, $this->validationMessagesFeatures($row['validationRulesArray'][$row['indexByName'].'_'.$i], 'feature_'.$row['indexByName'].'_'.$i, $row['upperName']));
                    }
                }
            }
        }
       // dd($data, $features_rules,$message_rules);
        $v = Validator::make($data, $features_rules, $message_rules);
        if ($v->fails()) {
            $array = [];
            $errors = $v->errors()->toArray();
            foreach ($errors as $error) {
                foreach ($error as $row) {
                    $array[] = $row;
                }
            }

            return array_unique($array);
        }
        $array = [];
        foreach ($features as $row) {
            $values = [];
            if (($row['max_num_values'] * 1) !== 1) {
                for ($i = 1; $i <= ($row['max_num_values'] * 1); $i++) {
                    if (!$data['feature_'.$row['indexByName'].'_'.$i]) {
                        continue;
                    }
                    if ($row['help_message'] != '' && (strpos('video image document', $row['input_type']) === false)) {
                        $message = '';
                        if (isset($row['helpMessageArray']['general'])) {
                            $message = $row['helpMessageArray']['general'];
                        } elseif (isset($row['helpMessageArray']['specific'])) {
                            $message = $row['helpMessageArray']['specific'][$row['indexByName'].'_'.$i];
                        } elseif (isset($row['helpMessageArray']['general_selection'])) {
                            $message = $data['help_msg_'.$row['indexByName']];
                        } elseif (isset($row['helpMessageArray']['specific_selection'])) {
                            $message = $data['help_msg_'.$row['indexByName'].'_'.$i];
                        }
                        $values[] = [$data['feature_'.$row['indexByName'].'_'.$i], $message];
                    } else {
                        $values[] = $data['feature_'.$row['indexByName'].'_'.$i];
                    }
                }
            } else {
                if (isset($data['feature_'.$row['indexByName']]) && !$data['feature_'.$row['indexByName']]) {
                    continue;
                }
                if ($row['help_message'] != '' && (strpos('video image document', $row['input_type']) === false)) {
                    $message = '';
                    if (isset($row['helpMessageArray']['general'])) {
                        $message = $row['helpMessageArray']['general'];
                    } elseif (isset($row['helpMessageArray']['general_selection'])) {
                        $message = $data['help_msg_'.$row['indexByName']];
                    }
                    $values = [$data['feature_'.$row['indexByName']], $message];
                } else {
                    $values = isset($data['feature_'.$row['indexByName']]) ? $data['feature_'.$row['indexByName']] : '';
                }
            }
            if ($values) {
                $array[$row['indexByName']] = $values;
            }
        }

        return json_encode($array);
    }

    /**
     * create the error message by taking the name feature, and validation rules.
     *
     * @param [string] $rules Validation rules
     * @param [string] $index name feature without spaces
     * @param [string] $name  name feature
     *
     * @return [array] $return
     */
    private function validationMessagesFeatures($rules, $index, $name)
    {
        $return = [];
        if (strpos($rules, '|in') !== false) {
            $return[$index.'.in'] = $name.' '.trans('features.is_invalid');
        }
        if (strpos($rules, '|numeric') !== false) {
            $return[$index.'.numeric'] = $name.' '.trans('features.only_allows_numbers');
            if (strpos($rules, '|min') !== false) {
                $num = explode('min:', $rules);
                $num = explode('|', $num[1]);
                $return[$index.'.min'] = $name.' '.str_replace('*N*', $num[0], trans('features.minimum_number'));
            } elseif (strpos($rules, '|max') !== false) {
                $num = explode('max:', $rules);
                $num = explode('|', $num[1]);
                $return[$index.'.max'] = $name.' '.str_replace('*N*', $num[0], trans('features.maximum_number_2'));
            } elseif (strpos($rules, '|between') !== false) {
                $num = explode('between:', $rules);
                $num = explode('|', $num[1]);
                $num = explode(',', $num[0]);
                $return[$index.'.between'] = $name.' '.str_replace(['*N1*', '*N2*'], $num, trans('features.between_n_and_n'));
            }
        } else {
            if (strpos($rules, '|alpha') !== false) {
                $return[$index.'.alpha'] = $name.' '.trans('features.only_allows_letters');
            }
            if (strpos($rules, '|min') !== false) {
                $num = explode('min:', $rules);
                $num = explode('|', $num[1]);
                $return[$index.'.min'] = $name.' '.str_replace('*N*', $num[0], trans('features.minimum_characters'));
            } elseif (strpos($rules, '|max') !== false) {
                $num = explode('max:', $rules);
                $num = explode('|', $num[1]);
                $return[$index.'.max'] = $name.' '.str_replace('*N*', $num[0], trans('features.maximum_characters'));
            } elseif (strpos($rules, '|between') !== false) {
                $num = explode('between:', $rules);
                $num = explode('|', $num[1]);
                $num = explode(',', $num[0]);
                $return[$index.'.between'] = $name.' '.str_replace(['*N1*', '*N2*'], $num, trans('features.between_n_and_n_characters'));
            }
        }
        if (strpos($rules, 'required_without_all') !== false) {
            $return[$index.'.required_without_all'] = $name.' '.trans('features.one_is_required');
        } elseif (strpos($rules, 'required_with') !== false) {
            $return[$index.'.required_with'] = $name.' '.trans('features.is_required');
        } elseif (strpos($rules, 'required') !== false) {
            $return[$index.'.required'] = $name.' '.trans('features.is_required');
        }

        return $return;
    }

    private function rulesByTypes($request, $edit = false)
    {
        $rules = $this->form_rules;
        switch ($request->input('type')) {
            case 'item':
                unset($rules['amount']); unset($rules['key']); unset($rules['software']);
                unset($rules['key_software']); unset($rules['software_key']);
            break;
            case 'key':
                unset($rules['amount']); unset($rules['stock']); unset($rules['low_stock']); unset($rules['software']);
                unset($rules['key_software']); unset($rules['software_key']);
                if ($edit) {
                    unset($rules['key']);
                }
            break;
            case 'software':
                unset($rules['amount']); unset($rules['stock']); unset($rules['low_stock']); unset($rules['key']);
                unset($rules['key_software']); unset($rules['software_key']);
                if ($edit) {
                    unset($rules['software']);
                }
            break;
            case 'software_key':
                unset($rules['amount']); unset($rules['stock']); unset($rules['low_stock']);
                unset($rules['key']); unset($rules['software']);
                if ($edit) {
                    unset($rules['key_software']);
                    unset($rules['software_key']);
                }
            break;
            case 'gift_card':
                unset($rules['stock']); unset($rules['low_stock']); unset($rules['key']); unset($rules['software']);
                unset($rules['key_software']); unset($rules['software_key']);
            break;
            default:
                return redirect()->back()
            ->withErrors(['induced_error' => [trans('globals.error').' '.trans('globals.induced_error')]])->withInput();
            break;
        }

        return $rules;
    }

    /**
     * Get the category id from tags array.
     *
     * @param [array] $tags, tags list to find out their categories
     *
     * @return [array] $categories, category id array
     */
    public static function getTagsCategories($tags = [])
    {
        $categories = Product::
            like('tags', $tags)
            ->groupBy('category_id')
            ->free()
            ->get(['category_id']);

        return $categories;
    }

    /**
     * Increase the product counters.
     *
     * @param [object] $product is the object which contain the product evaluated
     * @param [array]  $data    is the method config that has all the info requeried (table field, amount to be added)
     * @param [string] $wrapper is the products session array position key.
     */
    public static function setCounters($product = null, $data = [], $wrapper = '')
    {
        if (\Auth::user() && $product != '' && count($data) > 0) {
            $_array = Session::get('products.'.$wrapper); //products already evaluated
            if (count($_array) == 0 || !in_array($product->id, $_array)) {
                //looked up to make sure the product is not in $wrapper array already
                foreach ($data as $key => $value) {
                    if ($key != '' && $data[$key] != '') {
                        $product->$key = $product->$key + intval($data[$key]);
                        $product->save();
                    }
                }
                Session::push('products.'.$wrapper, $product->id); //build product list to not increase a product more than one time per day
                Session::save();
            }
        }
    }

    /**
     * To get a existing category id from products.
     *
     * @return [integer] $category_id [product category id field]
     */
    public static function getRandCategoryId()
    {
        $product = Product::select(['category_id'])
            ->free()
            ->orderByRaw('RAND()')
            ->take(1)
            ->first();

        return ($product) ? $product->id : 1;
    }

    /**
     * This method is able to return the higher rate product list, everything will depends of $point parameter.
     *
     * @param [integer] $point [it is the rate evaluates point, which allows get the products list required]
     * @param [integer] $limit [num of records to be returned]
     * @param [boolean] $tags  [it sees if we want to return a product list or a product tags list]
     *
     * @return [array or laravel collection] $_tags, $products [returning either products tags array or products collection]
     */
    public static function getTopRated($point = '5', $limit = 5, $tags = false)
    {
        if ($tags == true) {
            $products = Product::select(['id', 'tags', 'rate_count', 'rate_val'])
                ->WhereNotNull('tags')
                ->free()
                ->orderBy('rate_count', 'desc')
                ->orderBy('rate_val', 'desc')
                ->take($limit)
                ->get();

            $_tags = [];
            $products->each(function ($prod) use (&$_tags) {
                $array = explode(',', $prod->tags);
                foreach ($array as $value) {
                    if (trim($value) != '') {
                        $_tags[] = trim($value);
                    }
                }
            });

            return array_unique($_tags, SORT_STRING);
        } else {
            $products = Product::select(['id', 'name', 'description', 'features', 'price', 'type', 'stock'])
                ->free()
                ->orderBy('rate_count', 'desc')
                ->orderBy('rate_val', 'desc')
                ->take($limit)
                ->get();

            return $products;
        }
    }

    /**
     * getFeatures
     * Allows consulting products features. It can return either a required feature or a full array.
     *
     * @param array $data function setting
     *
     * @return [type] feature or a full array
     */
    public function getFeatures($data = [])
    {
        $options = [
            'product'    => [],
            'product_id' => '',
            'feature'    => '',
        ];

        $features = [];
        $data = $data + $options;

        if (count($data['product']) > 0) {
            $features = $data['product']->features;
        } elseif (trim($data['product_id']) != '') {
            $product = Product::find($data['product_id']);
            $features = $product->features;
        }

        return trim($data['feature']) != '' ? $features[$data['feature']] : $features;
    }
}
