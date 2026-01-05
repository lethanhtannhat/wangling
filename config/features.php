<?php

return [
    /*
    |--------------------------------------------------------------------------
    | App Features Toggle
    |--------------------------------------------------------------------------
    */
    'asset_list'   => env('FEATURE_ASSET_LIST', true),
    'asset_create' => env('FEATURE_ASSET_CREATE', true),
    'asset_sort'   => env('FEATURE_ASSET_SORT', true),
    'asset_filter' => env('FEATURE_ASSET_FILTER', true),
    'asset_edit'   => env('FEATURE_ASSET_EDIT', true),
    'asset_delete' => env('FEATURE_ASSET_DELETE', true),
];

