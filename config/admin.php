<?php
return [
    'path' => env('ADMIN_PATH', 'admin'),
    'middleware' => [
        'web', 'auth', 'perm:Administrator', 'cacheable'
    ]
];