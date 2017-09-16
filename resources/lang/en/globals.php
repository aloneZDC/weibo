<?php

//-------- For enums in Seeders --------
return [
    'company_status' => [
        'active'   => 'Active',
        'inactive' => 'Inactive',
    ],
    'person_sex'            => [ //used
        'female'          => 'Female',
        'male'            => 'Male',
    ],
    'roles' => [ //used
        'admin' => 'Administrator',
        'seller' => 'Seller',
        'customer' => 'Customer',
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
        'order_detail'            => 'order_detail',
        'paypal'                  => 'paypal',
    ],

    'product_features'        => [ //used
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
    ],

    'filters' => [ //used
        'categories'   => 'Categories',
        'category'     => 'Categories',
        'brand'        => 'Brand',
        'brands'       => 'Brands',
        'color'        => 'Color',
        'conditions'   => 'Conditions',
        'condition'    => 'Condition',
        'weight'       => 'Weight',
        'dimensions'   => 'Dimensions',
        'model'        => 'Model',
        'price'        => 'price',
        'price_range'  => 'Price Range',
        'size'         => 'size',
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
    'footer' => [
        'title_info'             => 'Information',
        'customer_service'       => 'Customer Service',
        'privacy_terms'          => 'Privacy Policy & Terms',
        'orders_returns'         => 'Orders and Returns',
        'title_buy'              => 'Why buy from us',
        'shipping_returns'       => 'Shipping & Returns',
        'secure_shopping'        => 'Secure Shopping',
        'international_shipping' => 'International Shipping',
        'business_sellers'       => 'Business Sellers',
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
    ],
    '404_error' => [
        'title'      => 'page not found',
        'message_01' => 'The page you were looking for appears to have been moved, deleted or does not exist. You could go back to where',
        'link_01'    => 'you were',
        'message_02' => 'or head straight to our',
        'link_02'    => 'home page',
    ],

    'id' => 'Id',

  'faq'                    => 'FAQs',
  'cancel'                 => 'Cancel', //used
  'contact'                => 'Contact',
  'file'                   => 'File',
  'help'                   => 'Help',
  'home'                   => 'Home',
  'notices'                => 'Notices',
  'privacy'                => 'Privacy',
  'products'               => 'Products', //used
  'refine'                 => 'Refine',
  'refine_by'              => 'Refine By',
  'search'                 => 'Search',
  'searching'              => 'Searching',
  'terms'                  => 'Terms',
  'type'                   => 'Type',
  'back_top'               => 'Back Top',
  'next'                   => 'Next',
  'previous'               => 'Previous',
  'click_here'             => 'Click here',
  'delete'                 => 'Delete', //used
  'edit'                   => 'Edit',
  'new'                    => 'New',
  'save'                   => 'Save',
  'search_suggestion'      => 'Search Suggestions',
  'disable'                => 'Disable',
  'enable'                 => 'Enable',
  'active'                 => 'Active',
  'brand'                  => 'Brand',
  'inactive'               => 'Inactive', //used
  'status'                 => 'Status', //used
  'integerValidate'        => 'must be a number integer',
  'numberValidate'         => 'must be a number',
  'required'               => 'Required',
  'required_image'         => 'Required image',
  'urlValidate'            => 'must be a url valid',
  'error'                  => 'Sorry, an error has occurred.',
  'fileErrorFormat'        => 'The file format is invalid',
  'not_access'             => 'You do not have permission to enter here.',
  'in'                     => 'in',
  'no'                     => 'No',
  'sub'                    => 'Sub',
  'to'                     => 'to',
  'total'                  => 'Total',
  'yes'                    => 'Yes',
  'action'                 => 'Action', //used
  'category'               => 'Category',
  'description'            => 'Description', //used
  'error_not_available'    => 'This content is not available.',
  'file_does_not_exist'    => 'File does not exist',
  'filter'                 => 'Filter',
  'filtered'               => 'Filtered', //used
  'filter_results'         => 'Filter Results',
  'induced_error'          => 'To better serve you follow the instructions properly.',
  'name'                   => 'Name', //used
  'no_results'             => 'No Results',
  'personalize'            => 'Personalize',
  'search_for'             => 'Search for',
  'searchResults'          => 'Search Results',
  'see_more'               => 'See more',
  'more'                   => 'More',
  'send_to'                => 'Send to',
  'subcategories'          => 'Subcategories',
  'with'                   => 'with',
  'worn_points'            => 'Expended points',
  'rate'                   => 'Rate',
  'due_date'               => 'Due on',
  'quantity'               => 'Quantity',
  'popular_tags'           => 'Products Tags Cloud',
  'actions_label'          => 'Actions',
  'sign_in_label'          => 'Sign In',
  'reference_label'        => 'Reference',
  'change_label'           => 'Change',
  'file_upload_error'      => "Sorry, you can't upload files over :MaxFilesize",
  'twitter_label'          => 'Twitter',
  'google_label'           => 'Google+',
  'facebook_label'         => 'Facebook',
  'about'                  => 'About Us',
  'all'                    => 'All',
  'comment'                => 'Comment',
  'delivery'               => 'Anywhere delivery',
  'events'                 => 'Upcoming Events',
  'free'                   => 'Free',
  'newsletter'             => 'Newsletter',
  'top_rated'              => 'Top Rated',
  'image'                  => 'Image',
  'points_earned'          => 'Points Earned',
  'close_label'            => 'Close', //used
  'customer_name'          => 'Customer Name',
  'full_report'            => 'Full Report',
  'filtered'               => 'Filtered By',
  'location'               => 'Location',
  'suggested_categories'   => 'Suggested Categories',
  'suggested_products'     => 'Suggested Products',
  'barcode_error_msg'      => 'The barcode could not be generated because the information was not valid',
  'max_label'              => 'Max',
  'min_label'              => 'Min',
  'go_label'               => 'Go',
  'max_price_label'        => 'Max Price',
  'min_price_label'        => 'Min Price',
  'your_search'            => 'Your search',
  'your_filter'            => 'Your filter',
  'message_no_filter'      => 'Trying changing one of the filters listed above to get a better result',
  'message_no_results_01'  => 'did not match any products',
  'message_no_results_02'  => 'Trying deleting one of the filters listed above to get a better result',
  'go_back_label'          => 'Go back',
  'result_for'             => 'Results for',
  'in_label'               => 'in',
  'by_label'               => 'by',
  'company_label'          => 'Company',
  'social_label'           => 'Social',
  'power_by_label'         => 'Power By',
  'antvel_eCommerce'       => 'Antvel eCommerce',
  'validation_error_label' => 'Validation Error',
  'success_label'          => 'Success', //used
  'success_text' => 'The process was successfully completed.', //used
  'error_label'          => 'Oops, it seems like something went wrong', //used
  'newsletter_email_error' => 'Email is required!',
  'reach_us_msg'           => 'Reach us by email anytime! We will be in touch as soon as possible.',
  'send_a_email_label'     => 'Send an email',
  'share_on_facebook'      => 'Share on Facebook',
  'share_on_twitter'       => 'Share on Twitter',

  'created_at' => 'Creatd At', //used
  'updated_at' => 'Updated At', //used
  'text' => 'Text', //used
  'select' => 'Select', //used
  'dashboard' => 'Dashboard', //used
  'price' => 'Price', //used
  'cost' => 'Cost', //used
  'details' => 'Details', //used
  'default' => 'Default', //used
  'notifications' => 'Notifications', //used
  'submit' => 'Submit', //used
  'zip_code' => 'Zip Code',
  'action_not_allowed' => 'The requested action is not allowed.',
];
