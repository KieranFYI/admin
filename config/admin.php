<?php
return [
    'path' => env('ADMIN_PATH', 'admin'),
    'service' => env('ADMIN_SERVICE', false),
    'middleware' => [
        'web', 'auth', 'perm:Administrator', 'cacheable'
    ]
];