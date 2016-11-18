<?php

//-------- For enums in Seeders --------
return [

    'company_status' => [
        'active'   => 'Active',
        'inactive' => 'Inactive',
    ],

    'roles' => [
        'admin'             => 'Administrator',
        'business'          => 'Business',
        'nonprofit'         => 'Non Profit',
        'person'            => 'Customer',
    ],

    'verification' => [
        'yes' => 'yes',
        'no'  => 'no',
    ],

    'type_user'               => [
        'normal'        => 'Normal',
        'trusted'       => 'Trusted',
    ],

    'type_preferences'        => [
        'string'             => 'String',
        'date'               => 'Date',
        'json'               => 'Json',
        'number'             => 'Number',
    ],

    'person_gender'            => [
        'female'          => 'Female',
        'male'            => 'Male',
    ],

    'type_categories'        => [
        'group'                 => 'Group',
        'store'                 => 'Store',
    ],

    'product_conditions'    => [
        'new'                    => 'New',
        'refurbished'            => 'Refurbished',
        'used'                   => 'Used',
    ],

    'order_status'            => [
        'cancelled'             => 'Cancelled', /*orden eliminada por el usuario*/
        'closed'                => 'Closed', /**/
        'open'                  => 'Open', /*orden abienta, en carrito, order,wish list*/
        'paid'                  => 'Paid', /**/
        'pending'               => 'Pending', /**/
        'received'              => 'Received', /**/
        'sent'                  => 'Sent', /**/
    ],

    'participant_status'    => [
        'cancelled'             => 'Cancelled',
        'registered'            => 'Registered',
        'winner'                => 'Winner',
    ],

    'source_types'            => [
        'tag'                     => 'tag',
        'order'                   => 'order',
        'free_product'            => 'free_product',
        'order_detail'            => 'order_detail',
        'paypal'                  => 'paypal',
    ],

    'product_features'        => [
        'color'                 => 'color',
        'weight'                => 'weight',
        'dimensions'            => 'dimensions',
        'volume'                => 'volume',
        'video'                 => 'video',
        'brand'                 => 'brand',
        'model'                 => 'model',
        'size'                  => 'size',
    ],

    'product_types'                => [
        'item'                    => 'item',
        'key'                     => 'key',
        'software'                => 'software',
        'software_key'            => 'software_key',
        'gift_card'               => 'gift_card',
        'freeproduct'             => 'freeproduct',
    ],

    'filters' => [
        'categories'   => 'Categories',
        'category'     => 'Categories',
        'brand'        => 'Brand',
        'brands'       => 'Brands',
        'color'        => 'Color',
        'conditions'   => 'Conditions',
        'condition'    => 'Condition',
        'model'        => 'Model',
        'price'        => 'price',
        'price_range'  => 'Price Range',
        'size'         => 'size',
    ],

    'action_types'            => [
        //Orders
        ['id' => 1, 'source_type' => 'order', 'action' => 'open'],
        ['id' => 2, 'source_type' => 'order', 'action' => 'pending'],
        ['id' => 3, 'source_type' => 'order', 'action' => 'comment'],
        ['id' => 8, 'source_type' => 'order', 'action' => 'closed'],
        ['id' => 9, 'source_type' => 'order', 'action' => 'cancelled'],
        ['id' => 10, 'source_type' => 'order', 'action' => 'received'],
        ['id' => 11, 'source_type' => 'order', 'action' => 'sent'],
        ['id' => 14, 'source_type' => 'order', 'action' => 'rate'],
        ['id' => 15, 'source_type' => 'order', 'action' => 'processing'],
        //Checkout
        ['id' => 6, 'source_type' => 'order', 'action' => 'reload points'],
        ['id' => 7, 'source_type' => 'order', 'action' => 'check out'],
        //Order Details
        ['id' => 4, 'source_type' => 'order_detail', 'action' => 'create'],
        ['id' => 5, 'source_type' => 'order_detail', 'action' => 'update'],
        //Free Products
        ['id' => 12, 'source_type' => 'free_product', 'action' => 'check out'],
        //PayPal
        ['id' => 13, 'source_type' => 'paypal', 'action' => 'buy points'],
    ],

    //------------ Globals Traductions----------------
    'product_features'        => [
        'brand'                    => 'brand',
        'color'                    => 'color',
        'dimensions'               => 'dimensions',
        'model'                    => 'model',
        'size'                     => 'size',
        'video'                    => 'video',
        'volume'                   => 'volume',
        'weight'                   => 'weight',
    ],

    // --- contain the field to increase (product table) and the constant value, which will be sum to the actual value.
    'product_value_counters' => [
        'view' => '1',
        'sale' => '1',
    ],

    '404_error' => [
        'title'      => 'page not found',
        'message_01' => 'The page you were looking for appears to have been moved, deleted or does not exist. You could go back to where',
        'link_01'    => 'you were',
        'message_02' => 'or head straight to our',
        'link_02'    => 'home page',
    ],

    //------------ Globals Traductions----------------
    'product_features'    => [
        'brand'         => 'brand',
        'color'         => 'color',
        'dimensions'    => 'dimensions',
        'model'         => 'model',
        'size'          => 'size',
        'video'         => 'video',
        'volume'        => 'volume',
        'weight'        => 'weight',
    ],

    // --- contain the field to increase (product table) and the constant value, which will be sum to the actual value.
    'product_value_counters' => [
        'view' => '1',
        'sale' => '1',
    ]
];
