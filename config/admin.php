<?php
return [
    'service' => env('ADMIN_SERVICE', false),
    'route' => [
        'enabled' => env('ADMIN_ROUTE_ENABLED', true),
        'path' => env('ADMIN_ROUTE_PATH', 'admin'),
        'middleware' => [
            'web', 'auth', 'perm:Administrator', 'cacheable'
        ]
    ],
    'api' => [
        'enabled' => env('ADMIN_API_ENABLED', true),
        'path' => env('ADMIN_API_PATH', 'admin/api'),
        'middleware' => [
            'web', 'auth', 'perm:Administrator', 'cacheable'
        ]
    ],
];