<?php

return [
    'sandbox' => [
        "app" => env('MP_SANDBOX_APP', null),
        'key' => env('MP_SANDBOX_KEY', null),
        'token' => env('MP_SANDBOX_TOKEN', null),
    ],
    'production' => [
        "app" => env('MP_APP', null),
        'key' => env('MP_KEY', null),
        'token' => env('MP_TOKEN', null),
    ]
];