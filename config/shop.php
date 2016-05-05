<?php

return [

    'name'              => env('SHOP_NAME', 'Creuset'),
    'logo'              => env('BRAND_LOGO', 'http://placehold.it/500'),

    'currency'          => env('SHOP_CURRENCY', 'GBP'),
    'currency_symbol'   => env('SHOP_CURRENCY_SYMBOL', '&pound;'),

    'products_per_page' => env('PRODUCTS_PER_PAGE', 8),

    /*
     * Must be a multiple of 12
     */
    'products_per_row'  => env('PRODUCTS_PER_ROW', 4),

    /*
     * Number of minutes a pending cart will be regarded as abandoned
     */
    'order_time_limit'  => env('ORDER_TIME_LIMIT', 15),

    /*
     * The user ids or emails, comma separated, who receive order and stock notifications
     */
    'admins'            => env('SHOP_ADMINS', '1'),

    /*
     * The stock quantity at which to alert shop admins
     */
    'low_stock_qty'     => 3,

];
