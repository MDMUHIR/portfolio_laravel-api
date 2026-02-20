<?php

return [
    'defaults' => [
        'global' => [
            'limit' => env('RATE_LIMIT_GLOBAL', 60),
            'decay' => env('RATE_LIMIT_DECAY', 60),
        ],
        'api' => [
            'limit' => env('RATE_LIMIT_API', 60),
            'decay' => env('RATE_LIMIT_DECAY', 60),
        ],
        'auth' => [
            'limit' => env('RATE_LIMIT_AUTH', 10),
            'decay' => env('RATE_LIMIT_DECAY', 60),
        ],
        'contact' => [
            'limit' => env('RATE_LIMIT_CONTACT', 5),
            'decay' => env('RATE_LIMIT_DECAY', 60),
        ],
    ],
];
